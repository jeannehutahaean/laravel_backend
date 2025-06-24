<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SummaryCard extends Component
{
    public $label;
    public $value;
    public $color;

    public function __construct($label, $value, $color)
    {
        $this->label = $label;
        $this->value = $value;
        $this->color = $color;
    }

    public function render()
    {
        return view('components.summary-card');
    }
}
