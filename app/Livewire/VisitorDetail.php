<?php

namespace App\Livewire;

use App\Models\SenseVisitor;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Class VisitorDetail
 * 
 * @package App\Livewire
 * 
 * This component handles the detailed view and management of a visitor profile.
 * It provides functionality for viewing, editing, and deleting visitor information,
 * including photo management.
 * 
 * Features:
 * - View visitor details including photo, name, card number, ID, and remarks
 * - Edit visitor information with validation
 * - Upload and update visitor photos
 * - Delete visitor profiles
 * - Cancel edit mode and revert changes
 */
class VisitorDetail extends Component
{
    use WithFileUploads;

    public $visitor;
    public $photo;
    public $name;
    public $cardNo;
    public $uniqueId;
    public $remarks;
    public $isEditing = false;

    /** @var SenseVisitor */
    public $visitor;

    /** @var \Livewire\TemporaryUploadedFile|null */
    public $photo;

    /** @var string */
    public $name;

    /** @var string */
    public $cardNo;

    /** @var string|null */
    public $uniqueId;

    /** @var string|null */
    public $remarks;

    /** @var bool */
    public $isEditing = false;

    /**
     * Initialize the component with visitor data
     * 
     * This method is called when the component is mounted. It populates
     * the component properties with the visitor's information if a visitor
     * model is provided.
     * 
     * @param SenseVisitor|null $visitor The visitor model instance
     * @return void
     */
    public function mount(SenseVisitor $visitor = null)
    {
        if ($visitor) {
            $this->visitor = $visitor;
            $this->name = $visitor->name;
            $this->cardNo = $visitor->card_no;
            $this->uniqueId = $visitor->unique_id;
            $this->remarks = $visitor->remarks;
        }
    }

    public function startEdit()
    {
        $this->isEditing = true;
    }

    /**
     * Save visitor information and handle photo upload
     * 
     * This method:
     * 1. Validates all input fields including the photo
     * 2. Updates the visitor record with new information
     * 3. Handles photo upload if a new photo is provided
     * 4. Stores the photo in the public storage
     * 5. Updates the photo_path in the database
     * 
     * Validation rules:
     * - name: Required, maximum 255 characters
     * - cardNo: Required, maximum 255 characters
     * - uniqueId: Optional, must be exactly 10 digits
     * - remarks: Optional, maximum 255 characters
     * - photo: Optional, must be an image file, maximum 1MB
     * 
     * @return void
     */
    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'cardNo' => 'required|string|max:255',
            'uniqueId' => ['nullable', 'string', 'size:' . SenseVisitor::VISITOR_ID_LENGTH, 'regex:/^[0-9]{' . SenseVisitor::VISITOR_ID_LENGTH . '}$/'],
            'remarks' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:1024',
        ]);

        $this->visitor->update([
            'name' => $this->name,
            'card_no' => $this->cardNo,
            'unique_id' => $this->uniqueId,
            'remarks' => $this->remarks,
        ]);

        if ($this->photo) {
            // Handle photo upload here
            $path = $this->photo->store('visitor-photos', 'public');
            $this->visitor->update(['photo_path' => $path]);
        }

        $this->isEditing = false;
        session()->flash('message', 'Visitor updated successfully.');
    }

    public function delete()
    {
        $this->visitor->delete();
        return redirect()->route('dashboard')->with('message', 'Visitor deleted successfully.');
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->reset(['photo']);
        $this->mount($this->visitor);
    }

    public function render()
    {
        return view('livewire.visitor-detail');
    }
}