<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardMemberRequest;
use App\Http\Requests\BoardMemberUpdateRequest;
use App\Http\Requests\PreviousBoardUpdateRequest;
use App\Models\BoardMember;
use App\Models\PreviousBoard;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $currentBoard = BoardMember::all();
        $previousBoards = PreviousBoard::all();

        return view('about-us.index', compact('currentBoard', 'previousBoards'));
    }

    public function edit_board_member(BoardMember $boardMember)
    {
        return view('about-us.board_member_edit', compact('boardMember'));
    }

    public function update_board_member(BoardMemberUpdateRequest $request, BoardMember $boardMember)
    {
        $validated = $request->validated();
        $request->hasFile('photo') && $validated['photo'] = $boardMember->replaceFile($request->file('photo'), 'board-members', 'public', 'photo');
        $boardMember->update($validated);

        return redirect()
            ->route('about-us.index')
            ->with('success', 'Bestuurslid succesvol bijgewerkt!');
    }

    public function edit_previous_board(PreviousBoard $previousBoard)
    {
        return view('about-us.previous_board_edit', compact('previousBoard'));
    }

    public function update_previous_board(PreviousBoardUpdateRequest $request, PreviousBoard $previousBoard)
    {
        $validated = $request->validated();
        $request->hasFile('photo') && $validated['photo'] = $previousBoard->replaceFile($request->file('photo'), 'previous-boards', 'public', 'photo');
        $previousBoard->update($validated);

        return redirect()
            ->route('about-us.index')
            ->with('success', 'Vorig bestuur succesvol bijgewerkt!');
    }

    public function create_board_member()
    {
        return view('about-us.board_member_create');
    }

    public function store_board_member(BoardMemberRequest $request)
    {
        //TODO: implement;
        $validated = $request->validated();
        $request->hasFile('photo') && $validated['photo'] = $request->file('photo')->store('about-us/personal', 'public');
        $communityNight = BoardMember::create($validated);
        $imageUrl = null;

        if ($communityNight->image) {
            $imageUrl = Storage::url($communityNight->image);
        }

        return redirect()
            ->route('about-us.index')
            ->with('success', 'Bestuurslid succesvol aangemaakt!');
    }
}
