<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardMemberUpdateRequest;
use App\Models\BoardMember;
use App\Models\PreviousBoard;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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

    public function edit_previous_board($id)
    {
        $previousBoard = PreviousBoard::findOrFail($id);
        $this->authorize('editPreviousBoard', $previousBoard);
        return view('about-us.previous_board_edit', compact('previousBoard'));
    }


    public function update_previous_board(Request $request, $id)
    {
        $previousBoard = PreviousBoard::findOrFail($id);
        $this->authorize('updatePreviousBoard', $previousBoard);
        $validated = $request->validate([
            'FromYear' => 'required|date',
            'ToYear' => 'required|date|after_or_equal:FromYear',
            'members' => 'required|string|min:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'FromYear.required' => 'Begin datum is verplicht.',
            'FromYear.date' => 'Begin datum moet een geldige datum zijn.',
            'ToYear.required' => 'Eind datum is verplicht.',
            'ToYear.date' => 'Eind datum moet een geldige datum zijn.',
            'ToYear.after_or_equal' => 'Einddatum moet op of na de begindatum zijn.',
            'members.required' => 'Ledenbeschrijving is verplicht.',
            'photo.image' => 'De afbeelding moet een geldig afbeeldingsbestand zijn.',
        ]);

        $previousBoard->FromYear = $validated['FromYear'];
        $previousBoard->ToYear = $validated['ToYear'];
        $previousBoard->members = $validated['members'];

        if ($request->hasFile('photo')) {
            if ($previousBoard->photo) {
                Storage::disk('public')->delete($previousBoard->photo);
            }

            $photoPath = $request->file('photo')->store('previous-boards', 'public');
            $previousBoard->photo = $photoPath;
        }

        $previousBoard->save();

        return redirect()
            ->route('previous-boards.edit', $previousBoard->id)
            ->with('success', 'Vorig bestuur succesvol bijgewerkt!');
    }


}
