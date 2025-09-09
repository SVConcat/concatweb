<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatueRequest;
use App\Models\Statue;
use App\Services\StatueService;

class StatueController extends Controller
{
    private StatueService $statueService;

    public function __construct(StatueService $statueService)
    {
        $this->statueService = $statueService;
    }

    public function index()
    {
        $statue = Statue::query()->first();
        return view('admin.statues.index', ['statue' => $statue]);
    }

    public function store(StatueRequest $request)
    {
        $this->statueService->storeStatue($request);
        return to_route('admin.statues.index');
    }

    public function update(StatueRequest $request)
    {
        $this->statueService->updateStatue($request);
        return to_route('admin.statues.index');
    }
}
