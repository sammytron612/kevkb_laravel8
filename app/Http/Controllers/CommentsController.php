<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;
use App\Articles;
use \App\Http\Helpers\Rating;
use Illuminate\Support\Facades\DB;
use App\Notifications\CommentAdded;
use App\User;


class CommentsController extends Controller
{


    public function addComment(Request $request)
    {


        $response = Comments::create(['articleid' => $request->articleid, 'comment' => $request->comment, 'userid' => auth()->user()->id, 'rating' => $request->rating]);
        

        $instance = new Rating;

        $article = Articles::find($request->articleid);
        $user = User::find($article->author);

        $data['title'] = $article->title;
        $data['commentor'] = auth()->user()->name;
        $data['comment'] = $request->comment;

        $user->notify(new CommentAdded($data));

       

        $message = $data['commentor'] . ", commented on your article" .chr(10);
        $message .= "'". $data['title'] . "'" . chr(10);
        $data['comment'] = $message;


        if($response)
        {
            $instance->avg_comment_rating($request->articleid);
            return response()->json("success",200);}
         else
        {
            return response()->json("failure",404);
        }
    }

    public function viewComments()
    {

        $comments['comments'] = DB::table('comments')->select('comment','name','title','comments.rating','comments.created_at')
        ->leftJoin('users','comments.userid','=','users.id')
        ->leftJoin('articles','comments.articleid','=','articles.id')->orderBy('comments.created_at','desc')
        ->orderBy('created_at','asc')
        ->paginate(10);

        return view('admin.view_comments', $comments);
    }


}
