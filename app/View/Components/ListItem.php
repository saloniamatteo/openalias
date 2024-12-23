<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListItem extends Component
{
    /* Create a new component instance. */
    public function __construct(
        public string $name,
    ) {}

    /* Get the view / contents that represent the component. */
    public function render()
    {
        return view('components.list-item');
    }
}
