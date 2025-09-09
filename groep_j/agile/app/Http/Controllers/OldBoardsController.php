<?php

namespace App\Http\Controllers;


use App\Http\Requests\OldBoardsRequest;
use App\Models\OldBoards;
use App\Services\OldBoardService;
use Illuminate\Http\Request;

class OldBoardsController extends Controller
{
    private OldBoardService $board;
    public function __construct(OldBoardService $board)
    {
        $this->board = $board;
    }
    public function index(Request $request){


        $data = $this->board->getEntries($request);
        return view('admin.old_boards.index', [
            'oldBoards' => $data['oldBoards'],
            'bindings' => $data['bindings'],
        ]);

    }
    public function create()
    {
        return view('admin.old_boards.form');
    }

    public function store(OldBoardsRequest $request)
    {
        $this->board->store($request);
        return redirect()->route('admin.old_boards.index');
    }

    public function show($id)
    {
        $oldBoard = OldBoards::findOrFail($id);
        return view('admin.old_boards.form', ['oldBoard'=> $oldBoard ]);
    }

    public function update(OldBoardsRequest $request, $id)
    {
        $this->board->update($request, $id);
        return redirect()->route('admin.old_boards.index');
    }


    public function delete($id){
        $this->board->delete($id);
        return redirect()->route('admin.old_boards.index');
    }
}
