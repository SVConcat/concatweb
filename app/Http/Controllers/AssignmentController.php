<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AssignmentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $assignments = Assignment::orderBy('created_at', 'desc')->paginate(6);

        return view('assignments.index', compact('assignments'));
    }

    public function store(AssignmentRequest $request)
    {
        Assignment::create($request->validated());

        return redirect()
            ->route('assignments.index')
            ->with('success', 'Opdracht succesvol aangemaakt.');
    }

    public function create()
    {
        return view('assignments.create');
    }

    public function edit(Assignment $assignment)
    {
        return view('assignments.edit', compact('assignment'));
    }

    public function update(AssignmentRequest $request, Assignment $assignment)
    {
        $validated = $request->validated();
        $assignment->update($validated);

        return redirect()
            ->route('assignments.index')
            ->with('success', 'Opdracht succesvol bijgewerkt.');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();

        return redirect()
            ->route('assignments.index')
            ->with('success', 'Opdracht succesvol verwijderd.');
    }
}
