<?php

namespace App\Http\Controllers;

use App\Models\BoardMember;
use App\Models\PreviousBoard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {

        $currentBoard = BoardMember::all();

        $previousBoards = PreviousBoard::all()->map(function ($board) {
             return [
            'id' => $board->id,
            'from' => \Carbon\Carbon::parse($board->FromYear)->format('Y'),
            'to' => \Carbon\Carbon::parse($board->ToYear)->format('Y'),
            'members' => $board->members,
            'photo' => $board->photo,
            ];
            });


        return view('about-us.index', compact('currentBoard', 'previousBoards'));
    }



    public function edit_board_member($id)
    {
        $boardMember = BoardMember::findOrFail($id);
        $this->authorize('editBoardMember', $boardMember);
        return view('about-us.board_member_edit', compact('boardMember'));
    }



    public function update_board_member(Request $request,  $id)
    {
        $boardMember = BoardMember::findOrFail($id);
        $this->authorize('updateBoardMember', $boardMember);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'required|string|min:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ],
        [
        'name.required' => 'Naam is verplicht.',
        'role.required' => 'Rol is verplicht.',
        'bio.required' => 'Bio is verplicht en moet minimaal 10 tekens bevatten.',
        'photo.image' => 'De afbeelding moet een geldig afbeeldingsbestand zijn.',
        ]);

        $boardMember->name = $validated['name'];
        $boardMember->role = $validated['role'];
        $boardMember->bio = $validated['bio'];

    if ($request->hasFile('photo')) {
        if ($boardMember->photo) {
            Storage::disk('public')->delete($boardMember->photo);
        }

        $photoPath = $request->file('photo')->store('board-members', 'public');
        $boardMember->photo = $photoPath;
        }
        $boardMember->save();

         return redirect()
            ->route('board-members.edit', $boardMember->id)
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
