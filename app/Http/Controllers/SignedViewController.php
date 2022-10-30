<?php
namespace app\Http\Controllers;
use App\Articles;
use App\ArticleBody;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class SignedViewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['signed']);
    }

    public function view(Request $request)
    {

        $data['article'] = Articles::find($request->id);
        $data['body'] = ArticleBody::find($request->id);

        $attachments = json_decode($data['article']->attachments);

        $a = null;
        $name = null;
        foreach ($attachments as $attachment)
        {

            $url = URL::temporarySignedRoute('signed.download', now()->addMinutes(60), ['attachment' => $attachment]);

            $a[] = $url;
            $n = explode("~", $attachment);
            $name[] = $n[1];

        }

        $data['attachments'] = $a;
        $data['names'] = $name;
        return view('external.view_article',$data);

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
