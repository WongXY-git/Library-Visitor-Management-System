<?php

namespace App\View\Components;

use Illuminate\View\Component;

class VisitorPhotoCard extends Component
{
    public string $name;
    public string $visitorId;
    public ?string $photoUrl;

    public function __construct(
        string $name = 'Visitor Name',
        string $visitorId = '000000000',
        ?string $photoUrl = null
    ) {
        $this->name = $name;
        $this->visitorId = $visitorId;
        $this->photoUrl = $photoUrl ?? asset('images/default-avatar.png');
    }

    public function render()
    {
        return view('components.visitor-photo-card');
    }
}