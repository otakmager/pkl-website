<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TMasuk;

class CariTmasuk extends Component
{
    use WithPagination;
    public $searchTerm = '';
    public $p = 5;
    public $label = [];
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.cari-tmasuk', [
            'tmasuks' => TMasuk::latest()->where('name','like', '%'. $this->searchTerm .'%')->paginate($this->p)
        ]);
    }

    public function updatingSearchTerm(){
        $this->resetPage();
    }
}
