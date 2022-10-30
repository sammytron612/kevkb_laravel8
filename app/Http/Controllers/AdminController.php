<?php

namespace App\Http\Controllers;
use App\User;
use App\Sections;
use App\Articles;
use App\ArticleBody;
use Session;
use Illuminate\Http\Request;
use App\Http\Helpers\NewArticleNotifications;
use App\Notifications\ArticleApprovedNotification;
use App\Notifications\ArticleRejectedNotification;
use App\UserLogin;
use App\Settings;
use App\Http\Helpers\FCMNotification;


class AdminController extends Controller
{


    private function stealth()
    {
        return Settings::find(1)->stealth;
    }

    public function index()
    {

        $data['stealth'] = $this->stealth();

        return view('admin.index',$data);
    }

    public function invites()
    {
        return view('admin.invites');

    }

    public function userManagement()
    {


        $data['users'] = User::paginate(10);

        return view('admin.usermanagement',$data);
    }

    public function edit_user($id)
    {
        $user['user'] = User::find($id);
        $user['logins'] = UserLogin::where('user_id',$id)->orderBy('last_login', 'desc')->limit(5)->get();

        return view('admin.edit_user', $user);
    }

    public function update_user(Request $request, $id )
    {
        $user = User::find($id);
        if ($request->status == "disabled")
        {

            $user->status = "disabled";
            $user->role = $request->role;
            $user->save();
            return redirect(route('admin.usermanagement'))->withSuccess('User successfully disabled');
        }
        else
        {
            $user->status = "active";
            $user->role = $request->role;
            $user->save();
            return redirect(route('admin.usermanagement'))->withSuccess('User successfully enabled');
        }
    }

    public function approvals()
    {

        $articles = Articles::where('approved',0)
                            ->where('published',1)
                            ->paginate(15);
        $pending['articles'] = $articles;

        return view('admin.approvals', $pending);

    }

    public function approval_show($id)
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

        return view('admin.approval_show', $article);

    }

    public function approval_update(Request $request, $id)
    {


        $validatedData = $request->validate([
            'title' => 'required|max:250',
            'sectionid' => 'required'

        ]);

        $count = 0;


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

            $images = $request->images;

            $images = explode("~",$images);

            for ($i = 1;$i < count($images); $i++)
            {
                $tmp = explode("/", $images[$i]);

                $img[] = end($tmp);

            }

        $existing_images[] = json_decode($article->images);

        $images = array_merge($existing_images, $img);


        #################################################

        $att = json_decode($article->attachments);

        if ($data)
        {
            $new_attach = (array_merge($data,$att));
            $article->attachments = $new_attach;
        }



        $article->title = $request->title;
        $article->tags = $request->tags;
        $article->sectionid = $request->sectionid;
        $article->scope = $request->scope;
        $article->images = json_encode($images);
        $article->attachCount = $article->attachCount + $count;
        $article->approved = 1;
        $article->published = 1;


        $section = Sections::find($article->sectionid);
        $section->noarticles ++;
        $section->save();

        $body = ArticleBody::find($id);
        $body->body = $request->body;
        $body->save();
        $user = User::find($article->author);

        if(!$article->notify_sent)
        {
            $data = [ 'user' => $user->name,
                            'section' => $article->sections->name,
                            'title' => $article->title,
                            'id' => $article->id

                        ];

            $notify = new NewArticleNotifications;
            $notify->new_article_notification($data);
        }

        $article->notify_sent = 1;
        $article->save();

        $data = [
            'title' => $article->title,
        ];


        $message = "Your article '" . $data['title'] . "'." . chr(10);
        $message .= "Has been approved.";
        $data['comment'] = $message;

        $fcmMessage = new FCMNotification;
        $fcmMessage->send($data,$user->id);

        $user->notify(new ArticleApprovedNotification($data));

        return redirect(route('admin.approvals'))->withSuccess('Article successfully approved');


    }

    public function rejection(Request $request)
    {


        $article = Articles::find($request->id);
        $article->approved = 0;
        $article->published = 0;
        $article->save();


        $user = User::find($request->author);

        $data = [

            'title' => $request->title,
            'reason' => $request->reason,
        ];

        $user->notify(new ArticleRejectedNotification($data));

        $message = "Sadly, your article '" . $data['title'] . "'." . chr(10);
        $message .= "Has been rejected." .chr(10);
        $message .= "For the following reason." .chr(10);
        $message .= "'" . $data['reason'] . "'";
        $data['comment'] = $message;

        $fcmMessage = new FCMNotification;

        $fcmMessage->send($data,$user->id);


        return redirect(route('admin.approvals'))->withSuccess('Article rejected');

    }



}
