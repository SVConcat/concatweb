<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardMemberRequest;
use App\Http\Requests\CommissionRequest;
use App\Models\Commission;
use App\services\BoardService;
use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use App\Services\CommissionService;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    private CommissionService $commission;
    public function __construct(CommissionService $board)
    {
        $this->commission = $board;
    }
    public function index(Request $request){

        $data = $this->commission->getEntries($request);
        return view('admin.commission.index', [
            'commissions' => $data['commissions'],
            'bindings' => $data['bindings'],
        ]);

    }
    public function create()
    {
        return view('admin.commission.form');
    }

    public function store(CommissionRequest $request)
    {
        $this->commission->store($request);
        return redirect()->route('admin.commission.index');
    }

    public function show($id)
    {
        $commission = Commission::findOrFail($id);
        return view('admin.commission.form', ['commission'=> $commission ]);
    }

    public function update(CommissionRequest $request, $id)
    {
        $this->commission->update($request, $id);
        return redirect()->route('admin.commission.index');
    }


    public function delete($id){
        $this->commission->delete($id);
        return redirect()->route('admin.commission.index');
    }
}
