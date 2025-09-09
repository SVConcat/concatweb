<?php

namespace App\Services;

use App\Http\Requests\BoardMemberRequest;
use App\Http\Requests\CommissionRequest;
use App\Models\BoardMember;
use App\Models\Commission;
use App\Services\ImageService;
use Illuminate\Http\Request;

class CommissionService
{

    private SearchService $searchService;



    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    public function getEntries(Request $request)
    {
        $query = Commission::query();

        if ($search = $request->get('search')) {
            $this->searchService->search($query, $search, Commission::class);
        }

        $commissions = $query->paginate(10)->appends($request->query());
        $bindings = array_keys($request->query());
        return [
            'commissions' => $commissions,
            'bindings' => $bindings,
        ];
    }
    public function store(CommissionRequest $request)
    {


        $validated = $request->validated();

        Commission::create($validated);
    }
    public function update(CommissionRequest $request, $id)
    {
        $board = Commission::findOrFail($id);
        $validated = $request->validated();


        $board->update($validated);
    }

    public function delete($id)
    {
        $board = Commission::findOrFail($id);
        $board->delete();
    }
}
