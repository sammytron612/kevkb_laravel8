<?php

namespace App\Http\Controllers;

use App\Articles;
use App\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Settings;


class SearchesController extends Controller
{

    public $search;

    public function __construct(Settings $settings)
    {
        $this->middleware(['auth']);
        $this->settings = $settings->find(1);

    }


    public function index()
    {
        return view('searches.index');
    }


    public function destroy($id)
    {

        $article = Articles::find($id);


        $section = Sections::find($article->sectionid);

        $section->noarticles --;


        $section->save();

        $attachments = new \App\Http\Helpers\Attachments;
        $attachments->delete($article);

        $response = $article->delete();
        if($response){
             return response()->json(['success']);
         }
         else
         {
            return response()->json(['failure']);
         }

    }


    public function search(Request $request)
    {

    $this->search = $request->get('search');

    $algolia = Null;
    $body = Null;


   // (Gate::check('stealth') && (Gate::check('isEditor') || Gate::check('isViewer')))

    $algolia = Articles::where('published', 1)
                        ->where('approved', 1)
                        ->where(function ($q){
                        $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('tags','like','%'.$this->search,'%');
                        })->get();


    foreach($algolia as $record)
        {
            $row[] = $record->id;
        }

    if ($this->settings->fulltext)
    {

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
        $body = DB::select($sql,[$search]);
    }


    $allRows = collect($algolia)->merge($body)->unique('id');


    $data['articles'] = $allRows;


    if($request->ajax())
       {
        return response()->json($data['articles']);
       }
    else
    {
        return view('searches.index',$data);
    }


    }
}
