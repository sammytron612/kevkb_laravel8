<?php
namespace App\Http\Helpers;
use App\Sections;

class SectionUpdate
{
    public function update($id,$id1)
    {

        if($id !== $id1)
        {
            $section = Sections::find($id);
            $section->noarticles --;
            $section->save();

            $section = Sections::find($id1);
            $section->noarticles ++;
            $section->save();

        }

        return;
    }


}
