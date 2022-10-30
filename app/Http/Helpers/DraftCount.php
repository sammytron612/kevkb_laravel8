<?php
namespace App\Http\Helpers;
use App\Articles;
use Auth;


class DraftCount
{
    public function numberOf()
    {
        $count = Articles::where('author', Auth::user()->id)
                            ->where('published', 0)->count();

        return $count;
    }

}
