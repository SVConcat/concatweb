<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AboutUsService;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    private AboutUsService $aboutUsService;
    public function __construct(AboutUsService $aboutUsService)
    {
        $this->aboutUsService = $aboutUsService;
    }
    public function index()
    {
        $data = $this->aboutUsService->getAboutUsData();

        return view('user.about_us.index', [
            'boards' => $data['boards'],
            'oldBoards' => $data['oldBoards'],
            'commissions' => $data['commissions']
        ]);
    }
}
