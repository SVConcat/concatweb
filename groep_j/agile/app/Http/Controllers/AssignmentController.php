<?php

namespace App\Http\Controllers;

use App\Enums\ActiveTypeEnum;
use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Services\AssignmentService;
use App\Services\SearchService;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    private AssignmentService $assignmentService;
    private SearchService $searchService;

    public function __construct(AssignmentService $assignmentService, SearchService $searchService)
    {
        $this->searchService = $searchService;
        $this->assignmentService = $assignmentService;
    }

    public function index(Request $request)
    {
        $query = $this->assignmentService->getAssignments();
        $bindings = array_keys(request()->query());

        if ($request->has("search") && $request->search != '') {
            $this->searchService->search($query, $request->search, Assignment::class);
        }

        if ($request->route()->named('admin.assignments.index')) {
            if($request->has('active') && $request->active != '') {
                $query->where('active', $request->active);
            }
            $assignments = $query->paginate(10)->appends(request()->query());
            return view('admin.assignments.index', ['assignments' => $assignments, 'bindings' => $bindings,]);
        }
        $assignments = $query->where('active', true)->paginate(10)->appends(request()->query());
        return view('user.assignments.index', ['assignments' => $assignments, 'bindings' => $bindings]);
    }

    public function create()
    {
        return view('admin.assignments.form');
    }

    public function store(AssignmentRequest $request)
    {
        $this->assignmentService->storeAssignment($request);
        return to_route('admin.assignments.index');
    }

    public function show(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        if ($request->route()->named('admin.assignment.show')) {
            return view('admin.assignments.form', ['assignment' => $assignment]);
        }
        return view('user.assignments.show', ['assignment' => $assignment]);
    }

    public function update(AssignmentRequest $request, $id)
    {
        $this->assignmentService->updateAssignment($request, $id);
        return to_route('admin.assignments.index');
    }

    public function delete($id)
    {
        $this->assignmentService->deleteAssignment($id);
        return to_route('admin.assignments.index');
    }
}
