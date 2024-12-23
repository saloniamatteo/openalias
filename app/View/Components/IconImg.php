<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IconImg extends Component
{
    /* Create a new component instance. */
    public function __construct(
        public string $alt,
        public string $href,
        public string $src,
    ) {}

    /* Get the view / contents that represent the component. */
    public function render()
    {
        return view('components.icon-img');
    }
}
