<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class SupporterOrganisations extends Component
{
    public array $logos;
    /**
     * Create a new component instance.
     */
    public function __construct($logos = [])
    {
        $this->logos = Storage::allFiles('public/logos/' . app()->getLocale());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.supporter-organisations');
    }
}
