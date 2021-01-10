<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\Category;

use Str;
use File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles=Article::orderBy('created_at','asc')->get();
        return view('back.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $categories = Category::orderBy('name','asc')->get();
       return view('back.articles.create',compact('categories'));
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
            'title'=>'min:3',
            'image'=>'required|image|max:2048'
        ]);

        $article = new Article;
        $article->title = $request->title;
        $article->category_id=$request->category;
        $article->content=$request->content;
        $article->slug=Str::slug($request->title);
        if ($request->hasFile('image')) {
            # code...
            //return "geldi"; die;
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $article->image='uploads/'.$imageName;
        }
        $article->save();
        toastr()->success('Success','Article Created!!');
        return redirect()->route('admin.articles.index');
        
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
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        //findOrFail // bulamadığında 404 kodu gönderir

        $categories=Category::all();
        return view('back.articles.edit',compact('categories','article'));
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
        //
        $request->validate([
            'title'=>'min:3',
            'image'=>'image|mimes:Jpeg,png,jpg|max:2048'
        ]);

        $article = Article::findOrFail($id);
        $article->title = $request->title;
        $article->category_id=$request->category;
        $article->content=$request->content;
        $article->slug=Str::slug($request->title);
        if ($request->hasFile('image')) {
            # code...
            //return "geldi"; die;
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $article->image='uploads/'.$imageName;
        }
        $article->save();
        toastr()->success('Success','Article Updated!!');
        return redirect()->route('admin.articles.index');
    }

    public function mySwitch(Request $request){
       $article = Article::findOrFail($request->id);
       $article->status = ($article->status == 0 ? 1:0);
       $article->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Article::find($id)->delete();
       toastr()->success('Success','Article Move Trashed!!');
        return redirect()->route('admin.articles.index');
    }

    public function recovery($id){
        Article::onlyTrashed()->find($id)->restore();
        toastr()->success('Success','Article Restoreted!!');
        return redirect()->route('admin.articles.index');
    }

    public function trashed(){
        $articles = Article::onlyTrashed()->orderBy('deleted_at','desc')->get();
        return view('back.articles.trashed',compact('articles'));
    }

    public function hardDestroy($id)
    {
        $article = Article::onlyTrashed()->find($id);
        if ( File::exists($article->image)) {
            File::delete(public_path($article->image));
        }
       
       $article->forceDelete();
       toastr()->success('Success','Article Deleted!!');
        return redirect()->route('admin.articles.index');
    }
}
