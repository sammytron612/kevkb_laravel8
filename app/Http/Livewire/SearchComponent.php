<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Articles;
use Illuminate\Support\Facades\DB;

class SearchComponent extends Component
{
    public $search;

    protected $queryString = ['search'];

    public function render()
    {   
    
        if(strlen($this->search))
        {

            $search1 = Articles::where('published', 1)
            ->where('approved', 1)
            ->where('public', 1)
            ->where(function ($q) {
            $q->where('title','like','%' . $this->search . '%')
            ->orWhere('tags','like','%' . $this->search . '%');
            })
            ->get();

        
        

            foreach($search1 as $record)
            {
                $row[] = $record->id;
            }



            if (isset($row))
                {
                $sql = "SELECT articles.id,articles.title,articles.views, articles.author_name as author_name, articles.kb as kb, articles.created_at as created_at, articles.rating as rating
                                FROM articles
                                join article_bodies ON articles.id = article_bodies.id
                                WHERE MATCH(article_bodies.body) AGAINST(? IN boolean mode) AND articles.published = 1 AND articles.approved = 1 AND article_bodies.id NOT IN (". implode(',', $row) .")";
                } else
                {
                    $sql = "SELECT articles.id,articles.title,articles.views, articles.author_name as author_name, articles.kb as kb, articles.created_at as created_at, articles.rating as rating
                                FROM articles
                                join article_bodies ON articles.id = article_bodies.id
                                WHERE MATCH(article_bodies.body) AGAINST(? IN boolean mode) AND articles.published = 1 AND articles.approved = 1";

                }
                $body = DB::select($sql,[$search1]);

                $allRows = collect($search1)->merge($body)->unique('id');


                $articles = $allRows;
        }
        else
        {
            $articles = [];
        }

        return view('livewire.search-component',['articles' => $articles]);
    
    }

    public function deleteArticle(Articles $article)
    {
        $article->delete();
        $this->dispatchBrowserEvent('update-success');
    }
}
