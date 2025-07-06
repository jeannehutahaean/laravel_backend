<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SummaryCard extends Component
{
    public string $label;
    public string|int $value;
    public string $color;

    public function __construct($label, $value, $color = 'text-gray-800')
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
