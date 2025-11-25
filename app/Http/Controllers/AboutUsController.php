<?php

namespace App\Http\Controllers;

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

        $previousBoards = PreviousBoard::all()->map(function ($board) {
            return [
                'id' => $board->id,
                'from' => Carbon::parse($board->FromYear)->format('Y'),
                'to' => Carbon::parse($board->ToYear)->format('Y'),
                'members' => $board->members,
                'photo' => $board->photo,
            ];
        });

        return view('about-us.index', compact('currentBoard', 'previousBoards'));
    }

    public function edit_board_member(BoardMember $boardMember)
    {
        $this->authorize('editBoardMember', $boardMember);
        return view('about-us.board_member_edit', compact('boardMember'));
    }

    public function update_board_member(BoardMemberUpdateRequest $request, BoardMember $boardMember)
    {
        $this->authorize('updateBoardMember', $boardMember);

        $boardMember->name = $request->validated('name');
        $boardMember->role = $request->validated('role');
        $boardMember->bio = $request->validated('bio');

        if ($request->hasFile('photo')) {
            if ($boardMember->photo) {
                Storage::disk('public')->delete($boardMember->photo);
            }

            $photoPath = $request->file('photo')->store('board-members', 'public');
            $boardMember->photo = $photoPath;
        }
        $boardMember->save();

        return redirect()
            ->back()
            ->with('success', 'Bestuurslid succesvol bijgewerkt!');
    }

    public function edit_previous_board(PreviousBoard $previousBoard)
    {
        $this->authorize('editPreviousBoard', $previousBoard);
        return view('about-us.previous_board_edit', compact('previousBoard'));
    }

    public function update_previous_board(PreviousBoardUpdateRequest $request, PreviousBoard $previousBoard)
    {
        $this->authorize('updatePreviousBoard', $previousBoard);

        $previousBoard->FromYear = $request->validated('FromYear');
        $previousBoard->ToYear = $request->validated('ToYear');
        $previousBoard->members = $request->validated('members');

        if ($request->hasFile('photo')) {
            if ($previousBoard->photo) {
                Storage::disk('public')->delete($previousBoard->photo);
            }

            $photoPath = $request->file('photo')->store('previous-boards', 'public');
            $previousBoard->photo = $photoPath;
        }

        $previousBoard->save();

        return redirect()
            ->back()
            ->with('success', 'Vorig bestuur succesvol bijgewerkt!');
    }
}
