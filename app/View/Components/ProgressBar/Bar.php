<?php

namespace App\View\Components\ProgressBar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Bar extends Component
{
    public $signatureCount;
    public $signaturePercentage;
    /**
     * Create a new component instance.
     */
    public function __construct($signatureCount, $signaturePercentage)
    {
        $this->signatureCount = $signatureCount;
        $this->signaturePercentage = $signaturePercentage;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.progress-bar.bar');
    }
}
