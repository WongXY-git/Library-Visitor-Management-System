<?php

namespace App\View\Components;

use Illuminate\View\Component;

class VisitorPhotoCard extends Component
{
    /**
     * Create a new visitor photo card component.
     * 
     * @param string $name The visitor's name
     * @param string $visitorId The visitor's ID
     * @param string|null $photoUrl The URL to the visitor's photo (optional)
     */
    public function __construct(
        public string $name,
        public string $visitorId,
        public ?string $photoUrl = null
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.visitor-photo-card');
    }
}