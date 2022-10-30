<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Storage;

class ImagesController extends Controller
{

    public function upload(Request $request)
    {

        $file=$request->file('file');
        $fileName = rand(0,1000) . time() . $file->getClientOriginalName();
        $path = $file->storeAs('images', $fileName);

        $path = Storage::url($path);
        echo json_encode(['location' => $path]);

    }

}

