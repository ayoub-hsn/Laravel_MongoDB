<?php

namespace App\Observers;

use App\Models\News;

class NewsObserver
{
    /**
     * Handle the News "created" event.
     *
     * @param  \App\Models\News  $news
     * @return void
     */
    public function created(News $news)
    {
        //
    }

    /**
     * Handle the News "updated" event.
     *
     * @param  \App\Models\News  $news
     * @return void
     */
    public function updated(News $news)
    {
        //
    }

    /**
     * Handle the News "deleted" event.
     *
     * @param  \App\Models\News  $news
     * @return void
     */
    public function deleting(News $news)
    {
        if($news->isForceDeleting()){
            $news->likes()->forceDelete();
            $news->dislikes()->forceDelete();
            $news->comments()->forceDelete();
        }else{
            $news->likes()->delete();
            $news->dislikes()->delete();
            $news->comments()->delete();
        }
    }

    /**
     * Handle the News "restored" event.
     *
     * @param  \App\Models\News  $news
     * @return void
     */
    public function restored(News $news)
    {
        $news->comments()->restore();
        $news->likes()->restore();
        $news->dislikes()->restore();
    }

    /**
     * Handle the News "force deleted" event.
     *
     * @param  \App\Models\News  $news
     * @return void
     */
    public function forceDeleted(News $news)
    {
        //
    }
}
