<?php

namespace App\Services;

use App\Http\Requests\BoardMemberRequest;
use App\Models\BoardMember;
use App\Services\ImageService;
use Illuminate\Http\Request;

class BoardService
{
    private SearchService $searchService;
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    public function getEntries(Request $request)
    {
        $query = BoardMember::query();

        if ($search = $request->get('search')) {
            $this->searchService->search($query, $search, BoardMember::class);
        }

        $boardMembers = $query->paginate(10)->appends($request->query());
        $bindings = array_keys($request->query());
        return [
            'boardMembers' => $boardMembers,
            'bindings' => $bindings,
        ];
    }
    public function store(BoardMemberRequest $request)
    {
        $validated = $request->validated();
        $validated['image'] = ImageService::storeImage($request,'image','/board') ?? ($validated['image']?? null);

        BoardMember::create($validated);
    }
    public function update(BoardMemberRequest $request, $id)
    {
        $board = BoardMember::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            ImageService::deleteImage(BoardMember::class, $board, 'image');
            $validated['image'] = ImageService::storeImage($request,'image','/board')  ?? ($validated['image'] ?? null);

        }


        $board->update($validated);
    }

    public function delete($id)
    {
        $board = BoardMember::findOrFail($id);
        if ($board->image) {
            ImageService::deleteImage(BoardMember::class, $board, 'image');

        }
        $board->delete();
    }
}
