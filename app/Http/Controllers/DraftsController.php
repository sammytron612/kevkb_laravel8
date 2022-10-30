<?php

namespace App\Http\Controllers;
use Auth;
use App\Articles;
use App\ArticleBody;
use App\Sections;
use Session;

class DraftsController extends Controller
{


    public function index()
    {
        $articles['drafts'] = Articles::where('author', Auth::user()->id)
                            ->where('published', 0)->paginate(10);

        return view('drafts.index',$articles);

    }

    public function edit($id)
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

        return view('drafts.edit', $article);
    }

    public function destroy($id)
    {
        $draft = Articles::find($id);
        $attachments = new \App\Http\Helpers\Attachments;
        $attachments->delete($draft);
        $draft->delete();
        $drafts = new \App\Http\Helpers\DraftCount;
        Session::put('count', $drafts->numberOf());
        $articles['drafts'] = Articles::where('author', Auth::user()->id)
                            ->where('published', 0)->paginate(10);
        return view('drafts.index',$articles)->withSuccess('Draft Delteted sucessfully');
    }
}
