<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Snows;


class SnowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $data['entries'] = Snows::paginate(15);
        return view('snow.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("snow.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:500',
            'tags' => 'required']);
        $tags = implode(" ", $request->tags);
        $snow = new Snows;
        $snow->title = $request->title;
        $snow->tags = $tags;
        if ($request->has('description'))
        {$snow->description = $request->description;}
        $snow->save();

        return redirect(route('snow.create'))->withSuccess('Snow group saved');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['entry'] = Snows::find($id);
        return view('snow.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:500',
            'tags' => 'required']);

        $snow = Snows::find($id);
        $tags = implode(" ", $request->tags);

        $title = $request->title;

        $snow->title = $title;
        $snow->tags = $tags;
        if ($request->has('description'))
        {$snow->description = $request->description;}
        $snow->save();

        return redirect(route("snow.index"));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $snow = Snows::find($id);
        $snow->delete();
        return redirect(route('snow.index'))->withSuccess('Snow group deleted');
    }

}
