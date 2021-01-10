<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Article;
use App\Models\Page;
use App\Models\Contact;

use App\Models\Config;

use Validator;
use Mail;


class Homepage extends Controller
{
    public function __construct(){
        
        if (Config::find(1)->active==0) {
            return redirect()->to('aktif-degil');
        }
        
        view()->share('pages',$data['pages']=Page::orderBy('order','ASC')->get());
        view()->share('categories',$data['categories']=Category::get());
        
    }

    public function index(){
        //print_r(Category::all());
        $data['articles']=Article::orderBy('created_at','DESC')->paginate(2);
        //$data['articles']->withPath(url('/sayfa')); // Kulanmak için route oluşturmak gerekiyor.
        //$data['categories']=Category::get();
        //$data['pages']=Page::orderBy('order','ASC')->get();
        return view('front.homepage',$data);
    }

    public function single($category,$slug){

        //$article=Article::where('slug',$slug)->first() ?? abort(403,'Böyle bir yazı bulunamadı!!');
        //dd($article);
        $category=Category::where('slug',$category)->first() ?? abort(403,'Böyle bir Kategori bulunamadı!!');
        $article= Article::where('slug',$slug)->whereCategoryId($category->id)->first() ?? abort(403,'Böyle bir yazı bulunamadı!!');
        $article->increment('hit');
        $data['article']=$article;
        //$data['categories']=Category::get();
        return view('front.single',$data);
    }

    public function category($slug){
        $category = Category::whereSlug($slug)->first() ?? abort(403,'Böyle bir kategori bulunamadı!');
        $data['category']=$category;
        $data['articles']=Article::whereCategoryId($category->id)->orderBy('created_at','DESC')->paginate(1);
        //$data['categories']=Category::get();
        return view('front.category',$data);
    }
    public function page($slug){
        $page=Page::whereSlug($slug)->first() ?? abort(403,'Böyle bir sayfa bulunamadı!');
        $data['page']=$page;
        //$data['pages']=Page::orderBy('order','ASC')->get();
        return view('front.page',$data);
    }

    public function contact(){
        return view('front.contact');
    }

    public function contactpost(Request $request){
        $rules=[
            'name'=>'required|min:5',
            'email'=>'required|email',
            'topic'=>'required',
            'message'=>'required|min:10'
        ];
        $validate=Validator::make($request->post(),$rules);

        if ($validate->fails()) {
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }


        //DB'ye yazma
        /* $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->topic = $request->topic;
        $contact->message = $request->message;
        $contact->save(); */


        //Gerçek Mail Adresine Yazma
        Mail::send([],[],function($message) use($request){
            $message->from('baskanf@baskan.com','Fikret BASKAN');
            $message->to('admin@baskan.com');
            $message->setBody('Mesajı Gönderen : '.$request->name.'<br/>Mesajı Gönderen Mail : '.$request->email.'<br/>Mesaj Konusu : '.$request->topic.'<br/>Mesaj : '.$request->message,'text/html');
            $message->subject($request->name.' is new message!');

        });

        return redirect()->route('contact')->with('success','Message send. Thank you.');
    }
}
