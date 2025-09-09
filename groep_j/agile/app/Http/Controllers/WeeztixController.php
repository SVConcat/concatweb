<?php

namespace App\Http\Controllers;

use App\Services\WeeztixService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WeeztixController extends Controller
{
    private WeeztixService $weeztixService;
    public function __construct(WeeztixService $weeztixService)
    {
        $this->weeztixService = $weeztixService;
    }

    /**
     * Display the API index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $exists = $this->weeztixService->checkTokenExists();
        return view('admin.weeztix.index',['tokenExists' => $exists]);
    }

    /**
     * Handle the callback from the OAuth Weeztix server.
     *
     * @param Request $request
     * @return
     */
    public function callback(Request $request)
    {
        $this->weeztixService->callback($request);
        return to_route("admin.weeztix.index");
    }

    /**
     * Create a new token for the site for Weeztix.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createToken(Request $request)
    {
        $request->session()->put("state", $state = Str::random(40));
        return redirect("https://auth.openticket.tech/tokens/authorize?" . http_build_query([
                "client_id" => env("OAUTH_CLIENT_ID", ""),
                "redirect_uri" => env("OAUTH_CLIENT_REDIRECT", ""),
                "response_type" => "code",
                "state" => $state,
            ]));
    }

    /**
     * Refresh the token for the site for Weeztix.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refreshToken()
    {
        $this->weeztixService->refreshToken();
        return redirect()->back()->with("success", "Token succesvol ververst");
    }
}
