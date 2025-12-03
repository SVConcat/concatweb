<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $assignments = Assignment::orderBy('created_at', 'desc')->paginate(6); // Sort by creation date
        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        $this->authorize('create', Assignment::class);
        return view('assignments.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Assignment::class);

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
        ], [
            'title.required' => 'Titel is verplicht.',
            'title.string' => 'Titel moet een tekst zijn.',
            'title.max' => 'Titel mag niet langer zijn dan 255 tekens.',
            'short_description.required' => 'Korte omschrijving is verplicht.',
            'short_description.string' => 'Korte omschrijving moet een tekst zijn.',
            'company_name.required' => 'Bedrijfsnaam is verplicht.',
            'company_name.string' => 'Bedrijfsnaam moet een tekst zijn.',
            'company_name.max' => 'Bedrijfsnaam mag niet langer zijn dan 255 tekens.',
            'email.email' => 'E-mailadres moet een geldig e-mailadres zijn.',
            'email.max' => 'E-mailadres mag niet langer zijn dan 255 tekens.',
            'phone_number.string' => 'Telefoonnummer moet een tekst zijn.',
            'phone_number.max' => 'Telefoonnummer mag niet langer zijn dan 255 tekens.',
        ]);

        Assignment::create($validatedData);

        return redirect()->route('assignments.index')->with('success', 'Opdracht succesvol aangemaakt.');
    }

    public function edit(Assignment $assignment)
    {
        $this->authorize('update', $assignment);
        return view('assignments.edit', compact('assignment'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $this->authorize('update', $assignment);

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
        ]);

        $assignment->update($validatedData);

        return redirect()->route('assignments.index')->with('success', 'Opdracht succesvol bijgewerkt.');
    }

    public function destroy(Assignment $assignment)
    {
        $this->authorize('delete', $assignment);
        $assignment->delete();
        return redirect()->route('assignments.index')->with('success', 'Opdracht succesvol verwijderd.');
    }
}
