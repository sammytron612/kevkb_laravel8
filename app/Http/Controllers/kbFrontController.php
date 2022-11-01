<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articles;
use App\ArticleBody;
use App\Comments;

class kbFrontController extends Controller
{
    public function show(Request $request)
    {
        $article = Articles::find($request->id);
        $article->views ++;
        $article->save();


        $attachments = json_decode($article->attachments);

        $article['attachments'] = $attachments;

        $article['article'] = $article;
        $article['body'] = ArticleBody::find($request->id);

        $article['comments'] = Comments::where('articleid',$request->id)->orderBy('created_at','desc')->get();

        $instance = new \App\Http\Helpers\Rating;
        $article['percentage'] = $instance->get_rating($request->id);



        return view('front.show', $article);
    }
}
