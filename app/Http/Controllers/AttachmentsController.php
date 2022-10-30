<?php

namespace App\Http\Controllers;
use App\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentsController extends Controller
{


    public function delete_attach(Request $request)
    {
        $id = $request->id;

        $article = Articles::find($id);

        $attachments = json_decode($article->attachments);

        $file = $request->inp;

        $index = array_search($file, $attachments);

        Storage::delete($file);
        unset($attachments[$index]);
        sort($attachments);

        $article->attachCount = ($article->attachCount)-1;

        $article->attachments = json_encode($attachments);
        $article->save();

        echo $request->btn_id;

    }

    public function download($attachment)
    {

        $url = storage_path() . "/app/public/" . $attachment;

        $mime =  mime_content_type($url);
        $headers =[
            'Content-Description' => 'File Transfer',
            'Content-Type' => $mime,
        ];


        $real_name = explode("~",$attachment);

        return Storage::download($attachment, $real_name[1], $headers);

    }
}

