<?php

namespace App\View\Components;


use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Statue;

class Footer extends Component
{
    public $statue;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->statue = Statue::query()->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer');
    }
}
