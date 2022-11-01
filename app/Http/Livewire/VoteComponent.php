<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Comments;
use App\Http\Helpers\Rating;
use App\Ratings;
use App\Articles;
use App\User;
use App\Notifications\CommentAdded;
use League\CommonMark\Inline\Element\Code;

class VoteComponent extends Component
{
    public $pct;
    public $article;
    public $comment;
    public $show = false;
    public $name;
    public $rating;

    public function mount()
    {
        $this->enabled = true;
    }

    public function render()
    {
        $comments = Comments::where('articleid', $this->article->id)->orderBy('created_at','desc')->get();
        
        return view('livewire.vote-component',['comments' => $comments]);
    }

    public function voteNo()
    {
        $this->enabled = false;
        Ratings::create(['articleid' => $this->article->id, 'userid' => 0, 'vote'=> 0]);
        $this->dispatchBrowserEvent('update-success');
    }

    public function voteYes(Rating $rating)
    {
        
        $this->enabled = false;
        Ratings::create(['articleid' => $this->article->id, 'userid' => 0, 'vote'=> 1]);
        $this->pct = $rating->get_rating($this->article->id);
        $this->dispatchBrowserEvent('update-success');
        
    }

    public function submit()
    {
        $response = Comments::create(['articleid' => $this->article->id, 'comment' => $this->comment, 'userid' =>0, 'name' => $this->name, 'rating'=>$this->rating]); 

        $instance = new Rating;
        $instance->avg_comment_rating($this->article->id);

        $article = Articles::find($this->article->id);
        $user = User::find($article->author);

        $data['title'] = $article->title;
        $data['commentor'] = $this->name;
        $data['comment'] = $this->comment;
        $this->dispatchBrowserEvent('update-success');
        $this->show = false;
        $user->notify(new CommentAdded($data));
        
    }
}
