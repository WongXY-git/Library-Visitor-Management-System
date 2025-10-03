<?php

namespace App\Livewire;

use App\Models\SenseVisitor;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

/**
 * Class Dashboard
 * 
 * @package App\Livewire
 * 
 * This component manages the main dashboard view of the visitor management system.
 * It handles the display of visitor cards in a grid layout with pagination and search functionality.
 * 
 * Features:
 * - Display visitor cards in a 4-column grid
 * - Paginate visitors (4 per page)
 * - Real-time search by name, card number, or unique ID
 * - Navigation to visitor creation form
 * - Responsive layout that adjusts based on screen size
 * 
 * The dashboard serves as the main interface for:
 * - Quick visitor overview with photos
 * - Access to detailed visitor information
 * - Adding new visitors to the system
 */
#[Layout('layouts.app')]
class Dashboard extends Component
{
    #[On('navigate')]
    public function navigate($url)
    {
        return $this->redirect($url);
    }
    use WithPagination;

    /**
     * Search query string for filtering visitors
     * @var string
     */
    public string $search = '';

    /**
     * Number of visitors to display per page
     * @var int
     */
    public $perPage = 4;

    /**
     * Query string parameters that should be preserved in the URL
     * @var array
     */
    protected $queryString = ['search'];

    /**
     * Handle the creation of a new visitor
     * Triggered by the "Add Visitor" button click
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * Navigate to visitor creation page
     */
    public function createVisitor()
    {
        return $this->redirect(route('visitor.create'));
    }

    /**
     * Render the dashboard component
     * 
     * This method:
     * 1. Filters visitors based on the search query
     * 2. Orders them by last update timestamp
     * 3. Paginates the results
     * 4. Returns the view with paginated visitors
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // PLACEHOLDER: Currently using local database records.
        // This will be replaced with API integration in production.
        $visitors = SenseVisitor::where(function($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('card_no', 'like', '%' . $this->search . '%')
                  ->orWhere('unique_id', 'like', '%' . $this->search . '%');
        })
        ->orderBy('updated_ts', 'desc')
        ->paginate($this->perPage);

        return view('livewire.dashboard', [
            'visitors' => $visitors
        ]);
    }
}