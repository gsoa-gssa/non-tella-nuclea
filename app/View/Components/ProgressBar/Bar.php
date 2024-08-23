<?php

namespace App\View\Components\ProgressBar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Component;

class Bar extends Component
{
    public $donationAmount;
    public $donationPercent;
    /**
     * Create a new component instance.
     */
    public function __construct($donationAmount, $donationPercent)
    {
        $this->donationAmount = $donationAmount;
        $this->donationPercent = $donationPercent;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.progress-bar.bar');
    }
}
