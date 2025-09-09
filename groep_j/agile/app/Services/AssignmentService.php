<?php
namespace App\Services;
use App\Models\Assignment;

class AssignmentService
{
    public function storeAssignment($request)
    {
        $data = $request->validated();
        $data['active'] = $request->input('active', false) === 'on';
        Assignment::create($data);
    }

    public function getAssignments()
    {
        return Assignment::query();
    }

    public function updateAssignment($request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->input('active', false) === 'on';
        $assignment = Assignment::findOrFail($id);
        $assignment->update($data);
    }

    public function deleteAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();
    }
}
