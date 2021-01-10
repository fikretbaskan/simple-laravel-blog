<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Article;
use Str;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::all();
        return view('back.categories.index',compact('categories'));
    }
    public function mySwitch(Request $request){
        $category = Category::findOrFail($request->id);
        $category->status = ($category->status == 0 ? 1:0);
        $category->save();
         
    }

    public function create(Request $request){
        //print_r($request->post());
        $isExists = Category::whereSlug(Str::slug($request->category))->first();
        if ($isExists) {
            toastr()->error('Error',$request->category.' Category is exists!!');
            return redirect()->back(); 
        }
        $category = new Category;
        $category->name = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Success','Category Created!!');
        return redirect()->back();
    }

    public function update(Request $request){
        $isExistsSlug = Category::whereSlug(Str::slug($request->slug))->whereNotIn('id',[$request->id])->first();
        $isExistsName = Category::whereName(($request->category))->whereNotIn('id',[$request->id])->first();
        if ($isExistsSlug or $isExistsName) {
            toastr()->error('Error',$request->category.' Category is exists!!');
            return redirect()->back(); 
        }
        $category =Category::find($request->id);
        $category->name = $request->category;
        $category->slug = Str::slug($request->slug);
        $category->save();
        toastr()->success('Success','Category Updated!!');
        return redirect()->back();
    }

    public function getData(Request $request){
        $category = Category::findOrFail($request->id);
        return response()->json($category);
    }

    public function delete(Request $request){
        $category = Category::findOrFail($request->deleteId);
        if ($category->id==12) {
            # code...
            toastr()->error('This category is not deleted!!');
            return redirect()->back();
        }
        $message = 'Category is deleted!!';
        $count = $category->getArticleCounts();
        if ($count>0) {
            Article::where('category_id',$category->id)->update(['category_id'=>12]);
            $message = $message.' '.$count.' count articles move to Genel category';
        }

        $category->delete();
        toastr()->success($message);
        return redirect()->back();
    }
}
