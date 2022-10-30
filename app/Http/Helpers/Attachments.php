<?php
namespace App\Http\Helpers;
use App\Articles;
use Illuminate\Support\Facades\Storage;

class Attachments
{
    public function delete(Articles $article)
    {

       //$article = Articles::find($id);
       $attachments = json_decode($article->attachments);

       foreach($attachments as $attachment)
       {
           $attachment = rtrim($attachment, '"');
           $attachment = ltrim($attachment, '"');


           try {
            Storage::delete($attachment);
            }
            catch(\Throwable $e)
            {
               //do nowt
            }

       }

       $images = json_decode($article->images, false);



       if ($images !== Null){
            foreach($images as $image)
            {

                    try {
                    Storage::delete("images/" . $image);
                    }
                    catch(\Throwable $e)
                    {
                    //do nowt
                    }

            }
        }

       return;

    }

}
