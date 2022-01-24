<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $allNews=News::all();
        $allNews->transform(function ($item, $key) {
            $item->likes_count = $item->likes()->count();
            $item->unLikes_count = $item->dislikes()->count();
            $item->comments_count = $item->comments()->count(); 
            return $item;
        });
        $mostLiked=$allNews->sortByDesc('likes_count')->take(2);
        
        $mostDisliked=$allNews->sortByDesc('unLikes_count')->take(2);;
        
        
        $news=News::with('user','likes','dislikes')->lastNews()->get();
        $news->transform(function ($item, $key) {
            $item->likes_count = $item->likes()->count();
            $item->unLikes_count = $item->dislikes()->count();
            $item->comments_count = $item->comments()->count(); 
            return $item;
        });
        
        return view('News.ShowNews',compact('news','mostLiked','mostDisliked'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('News.AddNews');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $news=new News();
        $pic=Storage::disk('public')->put('/News_Pictures',$request->picture);
        $news->picture=$pic;
        $news->title=$request->title;
        $news->content=$request->content;
        $request->user()->news()->save($news);
        return back()->with('News_Added','News Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $new = News::with('user','likes','dislikes','comments')->findOrFail($id);
        return view('News.ShowOneNew',compact('new'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $new=News::findOrFail($id);
        return view('News.EditNews',compact('new'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        $new = News::findOrFail($id);
        Storage::disk('public')->delete($new->picture);
        $pic=Storage::disk('public')->put('/News_Pictures',$request->picture);
        $new->picture = $pic;
        $new->title = $request->title;
        $new->content = $request->content;
        $new->save();
        return back()->with('News_Updated','News Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $new=News::withTrashed()->findOrFail($id);
        Storage::disk('public')->delete($new->picture);
        $new->forceDelete();
        return back()->with('News_Deleted','News Deleted Successfully');
    }
     public function archive($id){
        $new=News::findOrFail($id);
        $new->delete();
        return back()->with('News_Archive','News Archived Successfully');
     }

     public function showArchive(){
         $news=News::onlyTrashed()->with(['comments' => function($query){
            $query->onlyTrashed();
         }])
         ->with(['likes' => function($query){
             $query->onlyTrashed();
         }])
         ->with(['dislikes' => function($query){
            $query->onlyTrashed();
         }])
         ->where('user_id',Auth::user()->id)
         ->get();
         
         return view('News.ShowArchive',compact('news'));
     }

     public function restore($id){
        News::onlyTrashed()->find($id)->restore();
        return back()->with('News_Restored','News Restored Successfully');
     }
}
