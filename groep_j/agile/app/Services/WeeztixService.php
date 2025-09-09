<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Token;
use App\Models\User;
use GuzzleHttp\Client;

class WeeztixService
{
    public function callback($request): void
    {
        try {
            $state = $request->session()->pull('state');

            $response = (new Client)->post('https://auth.openticket.tech/tokens', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => config('app.oauth_client_id'),
                    'client_secret' => config('app.oauth_client_secret'),
                    'redirect_uri' => config('app.oauth_redirect_uri'),
                    'code' => $request->code,
                ],
            ]);

            $data = json_decode((string) $response->getBody(), true);

            Token::create([
                'access_token' => encrypt($data['access_token']),
                'refresh_token' => encrypt($data['refresh_token']),
                'expires_in' => $data['expires_in'],
                'refresh_token_expires_in' => $data['refresh_token_expires_in'],
                'guid' => $data['info']['companies'][0]['guid'],
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to handle callback: ' . $e->getMessage());
        }
    }

    public function refreshToken(): void
    {
        $refreshToken = decrypt(Token::first()->refresh_token);

        try {
            $response = (new Client)->post('https://auth.openticket.tech/tokens', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => config('app.oauth_client_id'),
                    'client_secret' => config('app.oauth_client_secret'),
                ],
            ]);

            $data = json_decode((string) $response->getBody(), true);

            $token = Token::first();
            $token->update([
                'access_token' => encrypt($data['access_token']),
                'refresh_token' => encrypt($data['refresh_token']),
                'expires_in' => $data['expires_in'],
                'refresh_token_expires_in' => $data['refresh_token_expires_in'],
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to refresh token: ' . $e->getMessage());
        }
    }

    /**
     * Get the list of events from Weeztix API.
     *
     * @return array
     */
    public function getEvents(): array
    {
        try {
            $response = $this->makeCurlUrlRequest('https://api.weeztix.com/event/');
            $responseData = json_decode($response, true);
        } catch (\Exception $e) {
            \Log::error('Failed to fetch events: ' . $e->getMessage());
            return ['' => 'Maak of herlaad de Weeztix token'];
        }
        return array_column($responseData, 'name', 'guid');
    }

    /**
     * Get the event capacity based on the event ID.
     *
     * @param string $eventId
     * @return float|int
     */
    public function getEventCapacity($eventId): float|int
    {
        try {
            $response = $this->makeCurlUrlRequest('https://api.weeztix.com/event/' . $eventId . '/ticket');
        } catch (\Exception $e) {
            \Log::error('Failed to fetch event capacity: ' . $e->getMessage());
            return 100; // Default to 100% if there's an error (full capacity / closed)
        }

        $responseData = json_decode($response, true);
        $totalSoldCount = array_sum(array_column($responseData, 'sold_count'));
        $totalAvailableCount = array_sum(array_column($responseData, 'available_stock'));
        if( $totalAvailableCount === 0) {
            return -1; // Return -1 to indicate unlimited capacity
        }
        $availability = $totalSoldCount / $totalAvailableCount * 100;
        return $availability;
    }

    /**
     * Register user events based on phone number inserted on order and registry.
     *
     * @param string $eventId
     * @return void
     */
    public function registerUserEvent($eventId): void
    {
        try {
            $accessToken = decrypt(Token::first()->access_token);
            $GUID = Token::first()->guid;

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer $accessToken",
                    "Company: $GUID"
                ],
                CURLOPT_URL => "https://api.weeztix.com/statistics/event/$eventId"
            ]);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                throw new \Exception('cURL error: ' . curl_error($curl));
            }

            curl_close($curl);

            $responseData = json_decode($response, true);

            if (isset($responseData['hits']['hits']) && is_array($responseData['hits']['hits'])) {
                foreach ($responseData['hits']['hits'] as $index => $hit) {
                    $metaData = $hit['_source']['meta_data'] ?? [];
                    $value = $metaData[2]['value'] ?? null;
                    \Log::info('Meta data', [
                        'index' => $index,
                        'value' => $value,
                        'event_id' => $eventId,
                        'user_id' => $hit['_source']['user_id'] ?? null,
                    ]);

                    if ($value) {
                        $phone = substr($value, -8);
                        $userId = User::where('phone', 'like', '%' . $phone)->value('id');
                        $eventDbId = Event::where('weeztix_event_id', $eventId)->value('id');

                        if ($eventDbId && $userId) {
                            if (!User::find($userId)->registeredEvents()->where('event_id', $eventDbId)->exists()) {
                                User::find($userId)->registeredEvents()->attach($eventId, [
                                    'event_id' => $eventDbId,
                                    'user_id' => $userId,
                                ]);
                            }
                        }
                    }
                }
            } else {
                \Log::error('No hits found in API response', $responseData);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to register user event: ' . $e->getMessage());
        }
    }

    /**
     * Make a cURL request to the given URL.
     *
     * @param string $url
     * @return bool|string
     */
    private function makeCurlUrlRequest($url): bool|string
    {
        $curl = curl_init();
        $GUID = Token::first()->guid;
        $accessToken = decrypt(Token::first()->access_token);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $accessToken",
                "Company: $GUID",
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function checkTokenExists()
    {
        return Token::exists();
    }
}
