<?php

namespace Modules\Pages\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Pages\Entities\Page;

class PagesController extends Controller
{

 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (view()->exists('pages.list'))

        {
            $page=Page::all();
            session()->flash('alert-type', 'success');
            session()->flash('message', 'Page is Loading .......');
            return view('pages.list')->with('page',$page);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (view()->exists('pages.new'))

        {

            return view('pages.new');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'show_on_main_menu' => 'required',
            'show_on_footer_menu' => 'required',
            'content' => 'required',
       ]);
       $page=Page::create([
        'title' => $request['title'],
        'slug' => $request['slug'],
        'show_on_main_menu' => $request['show_on_main_menu'],
        'show_on_footer_menu' => $request['show_on_main_menu'],
        'content' => $request['content'],
        'status' => 'active',
    ]);

        if($page)
        {
            session()->flash('alert-type', 'success');
            session()->flash('message', 'Page added successfully');
            return redirect()->route('page.index');
        }
        else{
            session()->flash('alert-type', 'error');
            session()->flash('message', 'Record Not Added.');
            return redirect()->back();
        }
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
        if (view()->exists('pages.new'))

        {

            $page=Page::findOrFail($id);
            session()->flash('alert-type', 'success');
            session()->flash('message', 'Page is Loading .......');
            return view('pages.new')->with('page',$page);
        }
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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'show_on_main_menu' => 'required|string|max:255',
            'show_on_footer_menu' => 'required|string|max:255',
            'content' => 'required',
       ]);

       $page=Page::whereId($id)->update([
        'title' => $request['title'],
        'slug' => $request['slug'],
        'show_on_main_menu' => $request['show_on_main_menu'],
        'show_on_footer_menu' => $request['show_on_main_menu'],
        'content' => $request['content'],
        ]);
        if($page)
        {
                session()->flash('alert-type', 'success');
                session()->flash('message', 'Page Updated Successfully.');
                return redirect()->route('page.index');
        }
        else{
            session()->flash('alert-type', 'error');
            session()->flash('message', 'Record Not Updated.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        session()->flash('alert-type', 'success');
        session()->flash('message', 'Page deleted successfully');

        return redirect()->route('page.index');
    }

    public function check_slug(Request $request)
    {

        $slug = Str::slug($request->title);
        if (Page::where('slug',$slug)->exists()) {
                    $random = rand(0, 99999);
                  echo json_encode($slug.'-'.$random);
                    exit;
                }
                else{

                  echo json_encode($slug);
                    exit;

                }

    }


    // /**
    //  * Display a listing of the resource.
    //  * @return Renderable
    //  */
    // public function index()
    // {
    //     return view('pages::index');
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  * @return Renderable
    //  */
    // public function create()
    // {
    //     return view('pages::create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  * @param Request $request
    //  * @return Renderable
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Show the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function show($id)
    // {
    //     return view('pages::show');
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function edit($id)
    // {
    //     return view('pages::edit');
    // }

    // /**
    //  * Update the specified resource in storage.
    //  * @param Request $request
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
