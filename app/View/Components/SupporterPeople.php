<?php

namespace App\View\Components;

use App\Models\Supporter;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SupporterPeople extends Component
{
    public $supporters;
    public $loadMore;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->supporters = Supporter::where("public", true)->where("email_verified_at", "!=", null)->limit(30)->get();
        if ($this->supporters->count() >= 25) {
            $this->loadMore = true;
        } else {
            $this->loadMore = false;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.supporter-people');
    }
}
