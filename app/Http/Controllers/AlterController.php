<?php

namespace App\Http\Controllers;
use App\Articles;
use App\Sections;
use App\ArticleBody;


class AlterController extends Controller
{

    public function alter($id)
    {
        $html = new \App\Http\Helpers\GenerateHtml;
        $sections = Sections::where('parent','0')->orderBy('name')->get();
        $table = $html->create_html($sections);
        $article['article'] = Articles::find($id);
        $article['body'] = ArticleBody::find($id);



        $attachments = json_decode($article['article']['attachments']);
        $article['attachments'] = $attachments;

        $article += [
            'html' => $table
        ];

        return view('alter.alter',$article);
    }


}

