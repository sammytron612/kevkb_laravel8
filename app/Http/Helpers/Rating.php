<?php
namespace App\Http\Helpers;
use App\Ratings;
use Illuminate\Support\Facades\DB;
use App\Articles;


class Rating
{
    public function avg_comment_rating($articleid)
    {

        $avg_rating = DB::table('comments')
                        ->where('articleid', $articleid)
                        ->avg('rating');

        $avg_rating = round($avg_rating, 1);

        Articles::where('id',$articleid)->update(['rating' => $avg_rating]);
   

        return true;

    }

    public function get_rating($articleid)
    {

        $total_vote = 0;
        $vote_yes = DB::table('ratings')
        ->where('articleid', $articleid)
        ->where('vote', '1')->get()->count();

        $total_vote = Ratings::where('articleid',$articleid)->get()->count();

        if(!$total_vote)
        {return $total_vote;}
        else {
        $percentage = ($vote_yes / $total_vote) * 100;

        return round($percentage,1);}
    }

    public function set_rating($articleid,$userid = 0,$vote)
    {

        $count = Ratings::where('articleid',$articleid)->Where('userid',$userid)->get()->count();

        if ($count > 2)
        {
            return false;
        }
        else
        {

            $new_rating = new Ratings;
            $new_rating->articleid = $articleid;
            $new_rating->vote = $vote;
            $new_rating->userid = $userid;
            $new_rating->save();
            return true;
        }


    }


}
