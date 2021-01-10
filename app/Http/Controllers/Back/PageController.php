<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

use Str;
use File;

class PageController extends Controller
{
    public function index(){
        $pages=Page::orderBy('order','ASC')->get();
        return view('back.pages.index',compact('pages'));
    }
    public function mySwitch(Request $request){
        $page = Page::findOrFail($request->id);
        $page->status = ($page->status == 0 ? 1:0);
        $page->save(); 
    }
    public function create(Request $request){
        return view('back.pages.create');
    }

    public function store(Request $request){
        $request->validate([
            'title'=>'min:3',
            'image'=>'required|image|max:2048'
        ]);
         //$last = Page::latest()->first();
        $last = Page::orderBy('order','DESC')->first();
        $page = new Page;
        $page->title = $request->title;
        $page->content=$request->content;
        $page->slug=Str::slug($request->title);
        $page->order = $last->order + 1;
        if ($request->hasFile('image')) {
            # code...
            //return "geldi"; die;
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $page->image='uploads/'.$imageName;
        }
        $page->save();
        toastr()->success('Success','Page Created!!');
        return redirect()->route('admin.pages.index');
    
        
   
    }

    public function edit($id){
        $pages=Page::findOrFail($id);
        return view('back.pages.edit',compact('pages'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'title'=>'min:3',
            'image'=>'image|mimes:Jpeg,png,jpg|max:2048'
        ]);

        $page = Page::findOrFail($id);
        $page->title = $request->title;
        $page->content=$request->content;
        $page->slug=Str::slug($request->title);
        if ($request->hasFile('image')) {
            # code...
            //return "geldi"; die;
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $page->image='uploads/'.$imageName;
        }
        $page->save();
        toastr()->success('Success','Page Updated!!');
        return redirect()->route('admin.page.index');
    }

    public function delete($id)
    {
       $page=Page::find($id);
       if (File::exists($page->image)) {
           # code...
           File::delete(public_path($page->image));
       }
       $page->forceDelete();
       toastr()->success('Success','Page Deleted!!');
        return redirect()->route('admin.page.index');
    }

    public function orders(Request $request){
       //print_r($request->get('page'));
      foreach ($request->get('page') as $key => $order) {
   
        page::where('id',$order)->update(['order'=>$key]);
      } 
    }
}
