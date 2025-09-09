<?php

namespace App\Services;

use App\Models\BoardMember;
use App\Models\Commission;
use App\Models\OldBoards;

class AboutUsService
{

    public function getAboutUsData(){
        $boards = BoardMember::all();
        $oldBoards = OldBoards::all()->sortByDesc(function($item)
            {
                preg_match('/^(\d{4})/',$item->term,$matches);
                return isset($matches[1]) ? $matches[1] : 0;
            });
        $commissions = Commission::all();
        return [
            'boards' => $boards,
            'oldBoards' => $oldBoards,
            'commissions' => $commissions
        ];
    }
}
