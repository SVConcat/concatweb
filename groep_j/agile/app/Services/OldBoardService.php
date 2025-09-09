<?php

namespace App\Services;

use App\Http\Requests\BoardMemberRequest;
use App\Http\Requests\OldBoardsRequest;
use App\Models\BoardMember;
use App\Models\OldBoards;
use App\Services\ImageService;

use Illuminate\Http\Request;

class OldBoardService
{
    private SearchService $searchService;
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    public function getEntries(Request $request)
    {
        $query = OldBoards::query()->orderBy('term', 'desc');

        if ($search = $request->get('search')) {
            $this->searchService->search($query, $search, OldBoards::class);
        }

        $oldBoards = $query->paginate(10)->appends($request->query());
        $bindings = array_keys($request->query());
        return [
            'oldBoards' => $oldBoards,
            'bindings' => $bindings,
        ];
    }
    public function store(OldBoardsRequest $request)
    {
        $validated = $request->validated();
        $validated['image'] = ImageService::storeImage($request,'image','/oldboard') ?? ($validated['image']?? null);

        OldBoards::create($validated);
    }
    public function update(OldBoardsRequest $request, $id)
    {
        $board = OldBoards::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            ImageService::deleteImage(OldBoards::class, $board, 'image');
            $validated['image'] = ImageService::storeImage($request,'image','/oldboard')  ?? ($validated['image'] ?? null);
        }


        $board->update($validated);
    }

    public function delete($id)
    {
        $board = OldBoards::findOrFail($id);
        if ($board->image) {
            ImageService::deleteImage(OldBoards::class, $board, 'image');
        }
        $board->delete();
    }
}
