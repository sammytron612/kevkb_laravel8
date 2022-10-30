<?php

namespace App\Http\Controllers;
use App\Articles;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{


    public function index()
    {
        return view('admin.stats');
    }

    public function stats_get($query)
    {

        $data['recent'] = Articles::select('title','created_at')
                                    ->where('published',1)
                                    ->where('approved',1)
                                    ->orderBy('created_at','desc')->limit(10)->get();

        if ($query == 1)
        {
        $data['articles'] = Articles::select('title','views')->orderBy('views','desc')->limit(10)->get();
        }

        if ($query == 2)
        {
            $sql ='SELECT count(*) as Count, users.name as Name FROM articles
            join users on articles.author = users.id
            group by author Limit 10';

            $data['author'] = DB::select($sql);

        }

        if ($query == 3)
        {
            $sql ='select articles.title as title, avg(vote) * 100 as rating
            from ratings,articles
            where articles.id = ratings.articleid
            group by ratings.articleid order by rating DESC LIMIT 10';

            $data['rated'] = DB::select($sql);

        }

        if ($query == 4)
        {
            $data['recent'] = Articles::select('id','title','created_at')
                                        ->where('published',1)
                                        ->where('approved',1)
                                        ->orderBy('created_at','desc')->limit(5)->get();

        }

        return response()->json($data);

    }
}
