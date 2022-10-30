<?php

namespace App\Http\Controllers;
use App\Sections;
use App\Articles;
use App\ArticleBody;
use App\Comments;
use App\Ratings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $html = new \App\Http\Helpers\GenerateHtml;
        $sections = Sections::where('parent','0')->orderBy('name')->paginate(25);
        $table = $html->create_html($sections);
        $data['sections'] = $sections;
        $data['html'] = $table;


        return view('sections.index', $data);

    }

    public function create()
    {
        $html = new \App\Http\Helpers\GenerateHtml;
        $sections = Sections::where('parent','0')->orderBy('name')->get();
        $table = $html->create_html($sections);


        $section = [
            'html' => $table
        ];

        return view('sections.create',$section);
    }

    public function update(Request $request, $id)
    {

        $section = Sections::find($id);

        if ($this->check_tree($request->parent, $id))
        {
            return redirect(route('sections.index'))->withErrors('Cannot move section to the same branch!');
        } else {
            $section->parent = $request->parent;
        }

        $section->name = $request->name;

        $section->save();

        return redirect(route('sections.index'))->withSuccess('Section updated successfully');

    }

    public function edit($id)
    {
        $html = new \App\Http\Helpers\GenerateHtml;
        $sections = Sections::where('parent','0')->orderBy('name')->get();
        $table = $html->create_html($sections);
        $section['section'] = Sections::find($id);
        $parent = $section['section']->parent;
        $section['parent'] = Sections::find($parent);
        $section['html'] = $table;
        return view('sections.edit',$section);
    }

    public function delete($id)
    {
        $html = new \App\Http\Helpers\GenerateHtml;
        $sections = Sections::where('parent','0')->orderBy('name')->get();
        $table = $html->create_html($sections);
        $section['html'] = $table;
        $section['section'] = Sections::find($id);
        return view('sections.destroy',$section);

    }

    public function check_tree($parent_id,$id)
        {
            $sql = "SELECT  t1.id as lev1_id, t2.id as lev2_id, t3.id as lev3_id, t4.id as lev4_id, t5.id as lev5_id, t6.id as lev6_id
            FROM sections AS t1
            LEFT JOIN sections AS t2 ON t2.parent = t1.id
            LEFT JOIN sections AS t3 ON t3.parent = t2.id
            LEFT JOIN sections AS t4 ON t4.parent = t3.id
            LEFT JOIN sections AS t5 ON t5.parent = t4.id
            LEFT JOIN sections AS t6 ON t6.parent = t5.id
            WHERE t1.id = ?";

            $rows = DB::select($sql, [$id]);

            foreach($rows as $row)
            {
                if  ($row->lev1_id == $parent_id)
                {
                    return true;
                }
                if  ($row->lev2_id == $parent_id)
                {
                    return true;
                }
                if  ($row->lev3_id == $parent_id)
                {
                    return true;
                }
                if  ($row->lev4_id == $parent_id)
                {
                    return true;
                }
                if  ($row->lev5_id == $parent_id)
                {
                    return true;
                }
                if  ($row->lev6_id == $parent_id)
                {
                    return true;
                }


                return false;

            }

        }

    public function destroy(request $request)
    {

        $parent_id = $request->parentid;

        $id = $request->sectionid;

        if(!$request->choice) //delete section and all children
        {
            $sql = "SELECT t1.id as lev1_id, t2.id as lev2_id, t3.id as lev3_id, t4.id as lev4_id, t5.id as lev5_id, t6.id as lev6_id
            FROM sections AS t1
            LEFT JOIN sections AS t2 ON t2.parent = t1.id
            LEFT JOIN sections AS t3 ON t3.parent = t2.id
            LEFT JOIN sections AS t4 ON t4.parent = t3.id
            LEFT JOIN sections AS t5 ON t5.parent = t4.id
            LEFT JOIN sections AS t6 ON t6.parent = t5.id
            WHERE t1.id = ?";

            $rows = DB::select($sql, [$id]);



            foreach ($rows as $row)
            {
                if($row->lev1_id)
                {

                    $articles = Articles::where('sectionid','=',$row->lev1_id)->get();
                    $attachments = new \App\Http\Helpers\Attachments;
                    foreach($articles as $article)
                    {
                        $attachments->delete($article);
                        $article->delete();

                        $article_body = ArticleBody::find($article->id);
                        $article_body->delete();

                        Comments::where('articleid',$article->id)->delete();
                        Ratings::where('articleid',$article->id)->delete();
                    }

                    Sections::where('id','=',$row->lev1_id)->delete();
                }

                if($row->lev2_id)
                {


                    $articles = Articles::where('sectionid','=',$row->lev2_id)->get();
                    $attachments = new \App\Http\Helpers\Attachments;

                    foreach($articles as $article)
                    {
                        $attachments->delete($article);
                        $article->delete();
                        $article_body = ArticleBody::find($article->id);
                        $article_body->delete();

                        Comments::where('articleid',$article->id)->delete();
                        Ratings::where('articleid',$article->id)->delete();
                    }
                    Sections::where('id','=',$row->lev2_id)->delete();

                }

                if($row->lev3_id)
                {
                    $articles = Articles::where('sectionid','=',$row->lev3_id)->get();
                    $attachments = new \App\Http\Helpers\Attachments;
                    foreach($articles as $article)
                    {
                        $attachments->delete($article);
                        $article->delete();
                        $article_body = ArticleBody::find($article->id);
                        $article_body->delete();

                        Comments::where('articleid',$article->id)->delete();
                        Ratings::where('articleid',$article->id)->delete();
                    }
                    Sections::where('id','=',$row->lev3_id)->delete();
                }

                if($row->lev4_id)
                {
                    $articles = Articles::where('sectionid','=',$row->lev4_id)->get();
                    $attachments = new \App\Http\Helpers\Attachments;
                    foreach($articles as $article)
                    {
                        $attachments->delete($article);
                        $article->delete();
                        $article_body = ArticleBody::find($article->id);
                        $article_body->delete();

                        Comments::where('articleid',$article->id)->delete();
                        Ratings::where('articleid',$article->id)->delete();
                    }
                    Sections::where('id','=',$row->lev4_id)->delete();
                }

                if($row->lev5_id)
                {
                    $articles = Articles::where('sectionid','=',$row->lev5_id)->get();
                    $attachments = new \App\Http\Helpers\Attachments;
                    foreach($articles as $article)
                    {
                        $attachments->delete($article);
                        $article->delete();
                        $article_body = ArticleBody::find($article->id);
                        $article_body->delete();

                        Comments::where('articleid',$article->id)->delete();
                        Ratings::where('articleid',$article->id)->delete();
                    }
                    Sections::where('id','=',$row->lev5_id)->delete();
                }

                if($row->lev6_id)
                {
                    $articles = Articles::where('sectionid','=',$row->lev6_id)->get();
                    $attachments = new \App\Http\Helpers\Attachments;
                    foreach($articles as $article)
                    {
                        $attachments->delete($article);
                        $article->delete();
                        $article_body = ArticleBody::find($article->id);
                        $article_body->delete();

                        Comments::where('articleid',$article->id)->delete();
                        Ratings::where('articleid',$article->id)->delete();
                    }
                    Sections::where('id','=',$row->lev6_id)->delete();
                }
            }

        }
            else
        {

            if($this->check_tree($parent_id,$id))
            {

                return redirect()->back()->withErrors("You cannot move a section to the same branch on a lower level!");
            }

            $articles =  Articles::where('sectionid','=',$id)->get();
            $attachments = new \App\Http\Helpers\Attachments;
            foreach($articles as $article)
             {
                $attachments->delete($article);
                $article->delete();
                $article_body = ArticleBody::find($article->id);
                $article_body->delete();

                Comments::where('articleid',$article->id)->delete();
                Ratings::where('articleid',$article->id)->delete();
             }

            Sections::where('id','=',$id)->delete(); //delete section with section id
            Sections::where('parent',$id)->update(['parent' => $parent_id]);  //update all sections with old parent to new


        }

        return redirect('sections')->withSuccess('Section(s) successfully deleted');



    }



    public function store(request $request)
    {
        $user = auth()->user();
        $section = new Sections;
        $section->parent = $request->parent;
        $section->name = $request->name;
        $section->author = $user->id;
        $section->noarticles = 0;

        if ($section->save())
        {
            return redirect('sections')->withSuccess('Section successfully added');
        }
        else
        {
            return redirect('sections')->withErrors('oops there was a problem');
        }


    }
}
