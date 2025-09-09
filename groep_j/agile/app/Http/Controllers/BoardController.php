<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardMemberRequest;
use App\Services\BoardService;
use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    private BoardService $board;
    public function __construct(BoardService $board)
    {
        $this->board = $board;
    }
    public function index(Request $request){

        $data = $this->board->getEntries($request);


        return view('admin.board.index', [
            'boardMembers' => $data['boardMembers'],
            'bindings' => $data['bindings'],
        ]);

    }
    public function create()
    {
        return view('admin.board.form');
    }

    public function store(BoardMemberRequest $request)
    {
        $this->board->store($request);
        return redirect()->route('admin.board.index');
    }

    public function show($id)
    {
        $boardMember = BoardMember::findOrFail($id);
        return view('admin.board.form', ['boardMember'=> $boardMember ]);
    }

    public function update(BoardMemberRequest $request, $id)
    {
        $this->board->update($request, $id);
        return redirect()->route('admin.board.index');
    }


    public function delete($id){
        $this->board->delete($id);
        return redirect()->route('admin.board.index');
    }
}
