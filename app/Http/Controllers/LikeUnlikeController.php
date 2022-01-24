<?php

namespace App\Http\Controllers;

use App\Models\Dislike;
use App\Models\Like;
use App\Models\News;
use Illuminate\Http\Request;

class LikeUnlikeController extends Controller
{
    public function likeNews(Request $request){
        $dislike=Dislike::where('user_id',$request->user()->id)->where('news_id',$request->id)->first();
        if(!empty($dislike)){
            $dislike->forceDelete(); 
        } 
        $like=new Like();
        $like->news_id = $request->id;
        $request->user()->likes()->save($like);
        return back();
    }

    public function unlikeNews(Request $request){
        
            $like=Like::where('user_id',$request->user()->id)->where('news_id',$request->id)->first();
            if(!empty($like)){
                $like->forceDelete(); 
            } 
            $dislike=new Dislike();
            $dislike->news_id = $request->id;
            $request->user()->dislikes()->save($dislike);
                return back();
        
    }
}
