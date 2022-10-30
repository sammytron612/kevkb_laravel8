<?php

namespace App\Http\Controllers;
use App\Snows;
use Illuminate\Http\Request;


class SnowSearchController extends Controller
{


    public function search()
    {
        $data['entries'] = Snows::paginate(15);
        return view('snow.search', $data);

    }

    public function results(Request $request)
    {
        if (!$request->has('search'))
        {
            return response()->json([
                'message' => 'error']);
        }

        $search = $request->get('search');
        $algolia['groups'] = Snows::search($search)->get();

        return response()->json($algolia['groups']);
    }
}
