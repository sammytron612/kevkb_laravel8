<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Settings;

class SettingsComponent extends Component
{
    public $settings;

    public $email_all;
    public $approve_articles;
    public $allow_delete;
    public $notifications;
    public $bts;
    public $fulltext;


    public function mount()
    {
        $this->settings = Settings::first();
        $this->email_all = $this->settings->email_all;
        $this->approve_articles = $this->settings->approve_articles;
        $this->allow_delete = $this->settings->allow_delete;
        $this->notifications = $this->settings->notifications;
        $this->bts = $this->settings->bts;
        $this->fulltext = $this->settings->fulltext;
    }

    public function render()
    {
        return view('livewire.settings-component');
    }

    public function updated($name, $value)
    {
        $int = (int) ($value);

        //dd($int);

        Settings::first()->update([$name => $int]);
        
    }


}
