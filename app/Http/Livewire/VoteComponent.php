<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VoteComponent extends Component
{
    public $pct;
    public $articleId;
    public $comment;

    public function render()
    {
        return view('livewire.vote-component');
    }

    public function voteNo()
    {

    }

    public function voteYes()
    {
        
    }

    public function link_submit_meta_box( $link:object )()
    {
        
    }
}
