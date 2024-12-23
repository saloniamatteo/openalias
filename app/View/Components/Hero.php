<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hero extends Component
{
    /* Create a new component instance. */
    public function __construct(
        public string $class,
        public string $id,
    ) {}

    /* Get the view / contents that represent the component. */
    public function render()
    {
        return view('components.hero');
    }
}
