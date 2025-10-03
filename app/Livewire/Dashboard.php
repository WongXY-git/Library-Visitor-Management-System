<?php

namespace App\Livewire;

use App\Models\SenseVisitor;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    use WithPagination;

    public string $search = '';
    
    // Dummy data for development
    public function getVisitors()
    {
        return [
            [
                'id' => '123456789',
                'name' => 'John Doe',
                'card_no' => 'V12345',
                'sense_id' => '987654',
                'photo' => null,
                'remarks' => 'Regular visitor',
            ],
            [
                'id' => '987654321',
                'name' => 'Jane Smith',
                'card_no' => 'V67890',
                'sense_id' => '123456',
                'photo' => null,
                'remarks' => 'Special access needed',
            ]
        ];
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'visitors' => $this->getVisitors()
        ]);
    }

    public function refresh()
    {
        // Will implement API sync later
        $this->dispatch('notify', [
            'message' => 'Data sync not implemented yet',
            'type' => 'info'
        ]);
    }
}