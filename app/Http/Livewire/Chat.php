<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\topikdiskusiM;
use App\Models\User;
use App\Models\diskusiM;

class Chat extends Component
{
    public $idtopikdiskusi, $diskusi;
    public function render()
    {
        $this->diskusi = diskusiM::where("idtopikdiskusi", $this->idtopikdiskusi)->get();
        return view('livewire.chat');
    }
}
