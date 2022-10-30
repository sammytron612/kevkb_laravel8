<?php
namespace App\Http\Helpers;
use App\Sections;
use Auth;
use Illuminate\Support\Facades\DB;

class GenerateHtml
{

    private function article_count($id)
    {


        $sql = "SELECT t1.id as lev1_id, t1.noarticles AS lev1_articles, t2.id as lev2_id, t2.noarticles AS lev2_articles, t3.id as lev3_id, t3.noarticles AS lev3_articles, t4.id as lev4_id, t4.noarticles AS lev4_articles, t5.id as lev5_id, t5.noarticles AS lev5_articles, t6.id as lev6_id, t6.noarticles AS lev6_articles
            FROM sections AS t1
            LEFT JOIN sections AS t2 ON t2.parent = t1.id
            LEFT JOIN sections AS t3 ON t3.parent = t2.id
            LEFT JOIN sections AS t4 ON t4.parent = t3.id
            LEFT JOIN sections AS t5 ON t5.parent = t4.id
            LEFT JOIN sections AS t6 ON t6.parent = t5.id
            WHERE t1.id = ?";

            $rows = DB::select($sql, [$id]);

        $lev1 = array();
        $lev2 = array();
        $lev3 = array();
        $lev4 = array();
        $lev5 = array();
        $lev6 = array();

        $count = 0;
       // $i = 0;
        foreach($rows as $row)
        {
           // print_r($row) ."<br>";

            if  ($row->lev1_articles)
            {

                if (!in_array($row->lev1_id, $lev1)){
                $count += $row->lev1_articles;
                array_push($lev1, $row->lev1_id);
                }
            }
            if  ($row->lev2_articles)
            {

                if (!in_array($row->lev2_id, $lev2)){
                    $count += $row->lev2_articles;
                    array_push($lev2, $row->lev2_id);
                    }
            }
            if  ($row->lev3_articles)
            {
                if (!in_array($row->lev3_id, $lev3)){
                    $count += $row->lev3_articles;
                    array_push($lev3, $row->lev3_id);
                    }
            }
            if  ($row->lev4_articles)
            {
                if (!in_array($row->lev4_id, $lev4)){
                    $count += $row->lev4_articles;
                    array_push($lev4, $row->lev4_id);
                    }
            }
            if  ($row->lev5_articles)
            {
                if (!in_array($row->lev5_id, $lev5)){
                    $count += $row->lev5_articles;
                    array_push($lev5, $row->lev5_id);
                    };
            }
            if  ($row->lev6_articles)
            {
                if (!in_array($row->lev6_id, $lev6)){
                    $count += $row->lev6_articles;
                    array_push($lev6, $row->lev6_id);
                    }
            }

        }

        return $count;
    }


    public function create_html($sections)
    {

        $user_role = Auth::user()->role;


        $html = "";
        foreach($sections as $section)
        {
            $edit = "";$delete = "";
            if ($user_role != "viewer"){
            $edit = '<a style="display:none" href="sections/edit/' . $section->id . '" class="section-btn px-1 py-0 btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>';}
            if ($user_role == "admin"){$delete = '<a style="display:none" href="sections/delete/' . $section->id . '" class="section-btn px-1 py-0 btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>';}



            $count = $this->article_count($section->id);

            $html .= '<tr id="' . $section->id . '" data-tt-id="' . $section->id . '"><td>' . $section->name . '</td><td></td><td>' . $count . '</td>';
            $html .='<td>' . $edit . $delete . '</td></tr>';

            $child = Sections::where('parent', $section->id)->get();

            foreach($child as $c) ///// lev2 /////
            {
                $count = $this->article_count($c->id);

                $edit = "";$delete = "";
                if ($user_role != "viewer"){
                $edit = '<a style="display:none" href="sections/edit/' . $c->id . '" class="section-btn px-1 py-0 btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>';}
                if ($user_role == "admin"){$delete = '<a style="display:none" href="sections/delete/' . $c->id . '" class="section-btn px-1 py-0 btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>';}


                $html .= '<tr id="' . $c->id . '" data-tt-id="' . $c->id . '"data-tt-parent-id="' . $c->parent . '"><td>' . $c->name . '</td><td></td><td>' . $count . '</td>';
                $html .='<td>' . $edit . $delete . '</td></tr>';

                    $child1 = Sections::where('parent', $c->id)->get();
                    foreach($child1 as $c1)  ///// lev3 /////
                    {
                        $count = $this->article_count($c1->id);
                        $edit = "";$delete = "";
                        if ($user_role != "viewer"){
                        $edit = '<a style="display:none" href="sections/edit/' . $c1->id . '" class="section-btn px-1 py-0 btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>';}
                        if ($user_role == "admin"){$delete = '<a style="display:none" href="sections/delete/' . $c1->id . '" class="section-btn px-1 py-0 btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>';}


                        $html .= '<tr id="' . $c1->id . '" data-tt-id="' . $c1->id . '"data-tt-parent-id="' . $c1->parent . '"><td>' . $c1->name . '</td><td></td><td>' . $count . '</td>';
                        $html .='<td>' . $edit . $delete . '</td></tr>';

                        $child2 = Sections::where('parent', $c1->id)->get();
                        foreach($child2 as $c2)  ///// lev4 /////
                        {
                            $count = $this->article_count($c2->id);
                            $edit = "";$delete = "";
                            if ($user_role != "viewer"){
                            $edit = '<a style="display:none" href="sections/edit/' . $c2->id . '" class="section-btn px-1 py-0 btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>';}
                            if ($user_role == "admin"){$delete = '<a style="display:none" href="sections/delete/' . $c2->id . '" class="section-btn px-1 py-0 btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>';}



                            $html .= '<tr id="' . $c2->id . '" data-tt-id="' . $c2->id . '"data-tt-parent-id="' . $c2->parent . '"><td>' . $c2->name . '</td><td></td><td>' . $count . '</td>';
                            $html .='<td>' . $edit . $delete . '</td></tr>';


                            $child3 = Sections::where('parent', $c2->id)->get();
                            foreach($child3 as $c3)  ///lev6 ///////
                            {
                                $count = $this->article_count($c3->id);
                                $edit = "";$delete = "";
                                if ($user_role != "viewer"){
                                $edit = '<a style="display:none" href="sections/edit/' . $c3->id . '" class="section-btn px-1 py-0 btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>';}
                                if ($user_role == "admin"){$delete = '<a style="display:none" href="sections/delete/' . $c3->id . '" class="section-btn px-1 py-0 btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>';}



                                $html .= '<tr id="' . $c3->id . '"  data-tt-id="' . $c3->id . '"data-tt-parent-id="' . $c3->parent . '"><td>' . $c3->name . '</td><td></td><td>' . $count . '</td>';
                                $html .='<td>' . $edit . $delete . '</td></tr>';

                                $child4 = Sections::where('parent', $c3->id)->get();
                                foreach($child4 as $c4)  ///// lev6 /////
                                {
                                    $count = $this->article_count($c4->id);
                                    $edit = "";$delete = "";
                                    if ($user_role != "viewer"){
                                    $edit = '<a style="display:none" href="sections/edit/' . $c4->id . '" class="section-btn px-1 py-0 btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>';}
                                    if ($user_role == "admin"){$delete = '<a style="display:none" href="sections/delete/' . $c4->id . '" class="section-btn px-1 py-0 btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>';}


                                    $html .= '<tr id="' . $c4->id . '"  data-tt-id="' . $c4->id . '"data-tt-parent-id="' . $c4->parent . '"><td>' . $c4->name . '</td><td></td><td>' . $count . '</td>';
                                    $html .='<td>' . $edit . $delete . '</td></tr>';


                                }

                            }

                        }

                    }
            }

        }

        $data['html'] = $html;

    return $html;

    }

}
