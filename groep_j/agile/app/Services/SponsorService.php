<?php

namespace App\Services;

use App\Http\Requests\SponsorRequest;
use App\Models\Sponsor;

class SponsorService
{
    public function getSponsors()
    {
        return Sponsor::query()->with('events');
    }

    public function storeSponsor(SponsorRequest $request)
    {
        $data = $request->validated();
        $data['image'] = ImageService::StoreImage($request, 'image', '/Sponsors') ?? ($data['image'] ?? null);
        $sponsor = Sponsor::create($data);
        $sponsor->events()->sync($request->input('events', []));
    }

    public function getSponsor($id)
    {
        return Sponsor::with('events')->find($id);
    }

    public function updateSponsor(SponsorRequest $request, $id)
    {
        $data = $request->validated();
        $sponsor = Sponsor::find($id);
        if ($request->hasFile('image')) {
            ImageService::deleteImage(Sponsor::class, $sponsor, 'image');
            $data['image'] = ImageService::StoreImage($request, 'image', '/Sponsors') ?? ($data['image'] ?? null);
        }
        $sponsor->update($data);
        $sponsor->events()->sync($request->input('events', []));
    }

    public function deleteSponsor($id)
    {
        $sponsor = Sponsor::find($id);
        if ($sponsor->image) {
            ImageService::deleteImage(Sponsor::class, $sponsor, 'image');
        }
        $sponsor->delete();
    }
}
