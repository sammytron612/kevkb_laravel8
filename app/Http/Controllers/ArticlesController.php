<?php

namespace App\Http\Controllers;
use App\Articles;
use App\Sections;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Comments;
use Illuminate\Support\Facades\DB;
use App\ArticleBody;
use App\Settings;
use App\Ratings;
use App\Http\Helpers\NewArticleNotifications;

class ArticlesController extends Controller
{


    private function approval()
    {
        return Settings::first()->approve_articles;
    }

    private function EditorDelete()
    {
        return Settings::first()->allow_delete;
    }


    public function index(Request $request, $sectionid = '%')
    {

        $bts = Settings::first()->bts;


        $data['articles'] = Articles::where('sectionid', 'like', $sectionid)
        ->where('published',1)
        ->where('approved',1)
        ->when($bts, function ($q){
            $q->where('bts', 1);
        })
        ->select('id','title','kb','sectionid','author','views','rating', 'created_at')
        ->orderBy('title')
        ->paginate(15);



        $data['ratings'] = Articles::where('sectionid', 'like', $sectionid)
                                    ->where('published',1)
                                    ->where('approved',1)
                                    ->when($bts, function ($q){
                                        $q->where('bts', 1);
                                    })
                                    ->select('id','title','sectionid','author','views','rating', 'created_at')
                                    ->orderBy('rating','desc')->limit(5)->get();

        $data['views'] = Articles::where('sectionid', 'like', $sectionid)
                                    ->where('published',1)
                                    ->where('approved',1)
                                    ->when($bts, function ($q){
                                        $q->where('bts', 1);
                                    })
                                    ->select('id','title','sectionid','author','views','rating', 'created_at')
                                    ->orderBy('views','desc')->limit(5)->get();

        $data['recents'] = Articles::where('sectionid', 'like', $sectionid)
                                    ->where('published',1)
                                    ->where('approved',1)
                                    ->when($bts, function ($q){
                                        $q->where('bts', 1);
                                    })
                                    ->select('id','title','sectionid','author','views','rating', 'created_at')
                                    ->orderBy('created_at','desc')->limit(8)->get();


        $sql =  "SELECT users.name, COUNT(*) as count FROM articles
        join users
        on articles.author = users.id
        where articles.sectionid like '$sectionid' AND articles.published = 1 AND articles.approved = 1 GROUP by articles.author order by count desc limit 5";

        $data['authors'] = DB::select($sql);


        $data['editor_delete'] = $this->EditorDelete();

        return view('articles.index',$data);


    }


    public function create()
    {
        $html = new \App\Http\Helpers\GenerateHtml;
        $sections = Sections::where('parent','0')->orderBy('name')->get();
        $table = $html->create_html($sections);
        $data['html'] = $table;
        return view('articles.create', $data);
    }


    public function store(Request $request)
    {

        $user = auth()->user()->id;
        $user_name = auth()->user()->name;

        $request->validate([
            'title' => 'required|max:500',
            'tags' => 'max:500',
            'sectionid' => 'required']);


        $data = array();
        $img = array();
        $count = 0;
        if($request->hasfile('attachments'))
        {

            $count = count($request->file('attachments'));
            foreach($request->file('attachments') as $file)
            {

                    $fileName = rand(0,1000) . time() . '~' . $file->getClientOriginalName();

                    $file->storeAs('', $fileName);

                    $data[] = $fileName;
            }
        }

        ##### prepare uploaded image urls ###

        $images = $request->images;

        $images = explode("~",$images);

        for ($i = 1;$i < count($images)-1; $i++)
        {
            $tmp = explode("/", $images[$i]);

            $img[] = end($tmp);

        }

            $article = new Articles;

            $article->title = $request->title;
            $article->slug = $request->title;
            $article->author = $user;
            $article->bts = $request->bts;
            //$article->author_name = $user_name;

            $article->sectionid = $request->sectionid;
            if (Auth::user()->role == "admin" || !$this->approval())
                {
                    $article->approved = 1;
                    if ($request->publish == 1){
                        $article->published = 1;

                        $section = Sections::find($request->sectionid);
                        $section->noarticles ++;
                        $section->save();
                    }
                    else
                    {
                        $article->published = 0;
                    }
                }
                else
                {
                    if ($request->publish == 1){
                        $article->published = 1;
                        $article->approved = 0;
                    }
                    else
                    {
                        $article->published = 0;
                        $article->approved = 0;
                    }
                }

            $article->tags = $request->tags;
            $article->scope = $request->scope;
            $article->attachments = json_encode($data);
            if(count($img) > 0)
            {$article->images = json_encode($img);}
            $article->attachCount = $count;


            $article->save();
            $len = strlen($article->id);
            $len = 5 - $len;
            $rand = "";
            for($i = 0; $i < $len; $i++)
            {
                $rand = $rand . mt_rand(0, 9);
            }


           $new_article = Articles::find($article->id);

           $new_article->kb =  "KB" . $article->id . $rand;
           $new_article->notify_sent = 1;
           $new_article->save();

           $new_article_body = new ArticleBody;
           $new_article_body->id = $article->id;
           $new_article_body->body = $request->body;
           $new_article_body->save();

           $drafts = new \App\Http\Helpers\DraftCount;
           Session::put('count', $drafts->numberOf());

            if ($article->published == 1)
            {

                if ($article->approved == 0)
                {

                    $approval = new \App\Http\Helpers\ApproveArticle;
                    $approval->approve_emails(Auth::user(), $request->title);
                    $new_article->notify_sent = 0;
                    $new_article->save();
                    return redirect(route('articles.index'))->withSuccess('Article pending approval.');
                }


                $data = [ 'user' => Auth::user()->name,
                          'section' => $article->sections->name,
                          'title' => $article->title,
                          'id' => $article->id,

                    ];

                $notify = new NewArticleNotifications;

                $notify->new_article_notification($data);



                return redirect(route('articles.index'))->withSuccess('Article successfully created');

            } else

            {
                return redirect(route('articles.index'))->withSuccess('Article saved to your drafts');
            }

    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'title' => 'required|max:500',
            'tags' => 'max:500',
            'sectionid' => 'required'

        ]);

        $user = auth()->user();
        $count = 0;
        $new_article = false;


        $data = null;


         if($request->hasfile('attachments'))
            {
              $count = count($request->file('attachments'));



              foreach($request->file('attachments') as $file)
                    {

                        $fileName = rand(0,1000) . time() . '~' . $file->getClientOriginalName();

                        $file->storeAs('', $fileName);

                        $data[] = $fileName;
                    }
            }

            $article = Articles::find($id);

            $was_published = $article->published;

            $uploaded_images = $request->images;

            if ($uploaded_images != "~")
            {
                $images = explode("~",$uploaded_images);
                $existing_images = json_decode($article->images);
                settype($existing_images, 'array');

                for ($i = 1;$i < count($images)-1; $i++)
                {
                    $tmp = explode("/", $images[$i]);

                    array_push($existing_images, end($tmp));

                }


            }

        #################################################

        $att = json_decode($article->attachments);

        if ($data)
        {
            $new_attach = (array_merge($data,$att));
            $article->attachments = $new_attach;
        }


            $article->title = $request->title;
            $article->tags = $request->tags;

            if (Auth::user()->role == "admin" || !$this->approval())
                {
                    if ($request->publish == 1){
                        if($article->published == 1)
                            {
                            $section = Sections::find($article->sectionid);
                            $section->noarticles --;
                            $section->save();


                            $section = Sections::find($request->sectionid);
                            $section->noarticles ++;
                            $section->save();
                            } else {
                        $article->published = 1;
                        $section = Sections::find($request->sectionid);
                        $section->noarticles ++;
                        $section->save();}
                    }
                    else
                    {
                        $article->published = 0;
                    }
                } else
                {
                    if ($request->publish == 1)
                        {
                            $article->published = 1;
                        }
                }




            $article->sectionid = $request->sectionid;
            $article->scope = $request->scope;
            if (isset($existing_images)){$article->images = json_encode($existing_images);}

            $article->attachCount = $article->attachCount + $count;

            $updated_article_body = ArticleBody::find($id);
            $updated_article_body->body = $request->body;
            $updated_article_body->save();

            $article->save();
            $instance = new \App\Http\Helpers\DraftCount;
            Session::put('count', $instance->numberOf());

            if($article->published && $article->approved && Auth::user()->role == "editor" && $this->approval())
            {
                $article->approved = 0;
                $article->save();


            }


            if ($article->published )
            {
                if (!$article->approved && $this->approval())
                {

                    $approval = new \App\Http\Helpers\ApproveArticle;
                    $return = $approval->approve_emails(Auth::user(), $request->title);
                    return redirect(route('articles.index'))->withSuccess('Article pending approval.');
                }

                if ($was_published == 0 && $article->published == 1)
                {

                    $data = [ 'user' => Auth::user()->name,
                          'section' => $article->sections->name,
                          'title' => $article->title,
                          'id' => $article->id,
                          'url' => url() . '/articles/' . $article->id,

                    ];

                    $notify = new NewArticleNotifications;
                    $notify->new_article_notification($data);


                }
                return redirect(route('articles.index'))->withSuccess('Article successfully Updated');

            } else

            {
                return redirect(route('articles.index'))->withSuccess('Article saved to your drafts');
            }

    }

    public function show($id)
    {
        $article = Articles::find($id);
        $article->views ++;
        $article->save();


        $attachments = json_decode($article->attachments);

        $article['attachments'] = $attachments;

        $article['article'] = $article;
        $article['body'] = ArticleBody::find($id);

        $article['comments'] = Comments::where('articleid',$id)->orderBy('created_at','desc')->get();

        $instance = new \App\Http\Helpers\Rating;
        $article['percentage'] = $instance->get_rating($id);



        return view('articles.show', $article);
    }


     public function destroy($id)
    {


       $article = Articles::find($id);
       $article_body = ArticleBody::find($id);
       $article_body->delete();

       Comments::where('articleid',$id)->delete();
       Ratings::where('articleid',$id)->delete();

       $drafts = new \App\Http\Helpers\DraftCount;
       Session::put('count', $drafts->numberOf());

       $section = Sections::find($article->sectionid);

       $section->noarticles --;


       $section->save();

       $attachments = new \App\Http\Helpers\Attachments;
       $attachments->delete($article);
       $article->delete();


        return redirect()->back()->withSuccess('Article successfully Deleted');


    }

    public function rating_set(Request $request)
    {
        $vote = $request->vote;
        $userid = auth()->user()->id;
        $articleid = $request->articleid;


        $instance = new \App\Http\Helpers\Rating;

        $response = $instance->set_rating($articleid,$userid,$vote);

        if($response)
        {
            return response()->json("success");
        }
         else
        {
            return response()->json("failure");
        }

    }

}
