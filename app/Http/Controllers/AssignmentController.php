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

    public function create()
    {
        $this->authorize('create', Assignment::class);
        return view('assignments.create');
    }

    public function store(AssignmentRequest $request)
    {
        $this->authorize('create', Assignment::class);

        Assignment::create($request->validated());

        return redirect()
            ->route('assignments.index')
            ->with('success', 'Opdracht succesvol aangemaakt.');
    }

    public function edit(Assignment $assignment)
    {
        $this->authorize('update', $assignment);
        return view('assignments.edit', compact('assignment'));
    }

    public function update(AssignmentRequest $request, Assignment $assignment)
    {
        $this->authorize('update', $assignment);

        $assignment->update($request->validated());

        return redirect()
            ->route('assignments.index')
            ->with('success', 'Opdracht succesvol bijgewerkt.');
    }

    public function destroy(Assignment $assignment)
    {
        $this->authorize('delete', $assignment);
        $assignment->delete();

        return redirect()
            ->route('assignments.index')
            ->with('success', 'Opdracht succesvol verwijderd.');
    }
}
