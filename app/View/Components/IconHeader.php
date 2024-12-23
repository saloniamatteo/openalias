<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IconHeader extends Component
{
    /* Create a new component instance. */
    public function __construct(
        public string $link,
        public string $icon,
    ) {}

    /* Get the view / contents that represent the component. */
    public function render()
    {
        return view('components.icon-header');
    }
}
