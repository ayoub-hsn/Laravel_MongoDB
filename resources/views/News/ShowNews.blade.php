<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All News') }}
        </h2>
    </x-slot>
    @if (Session::has('News_Archive'))
        <div class="alert alert-success">{{Session::get('News_Archive')}}</div>
    @endif
    @if (Session::has('News_Deleted'))
        <div class="alert alert-danger">{{Session::get('News_Deleted')}}</div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="row">
                    <div class="col-6">
                        @forelse ($news as $new)
                            <div class="card mb-3">
                                <h3 class="card-header">
                                    {{$new->title}} 
                                    <div class="btn-group float-right">
                                        <button type="button" class=" dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{route('news.show',['news' => $new->id])}}">View</a></li>
                                        @can('update',$new)
                                            <li><a class="dropdown-item" href="{{route('news.edit',['news' => $new->id])}}">Update</a></li>
                                        @endcan
                                        @can('delete',$new)
                                           <li>
                                                <form action="{{route('news.destroy',['news' => $new->id])}}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                   <button class="dropdown-item" type="submit">Delete</button> 
                                                </form>   
                                        @endcan
                                        @can('forceDelete',$new)
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{route('news.archiver',['news' => $new->id])}}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="dropdown-item" type="submit">Archive</button>
                                                </form>
                                            </li> 
                                        @endcan
                                        </ul>
                                    </div>
                                </h3>
                                    <img src="{{Storage::url($new->picture)}}" alt="{{$new->picture}}">
                                <div class="card-body">
                                    <p class="card-text">{{$new->content}}</p>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <span class="badge bg-info mr-3">{{$new->likes_count}} Likes</span>
                                        <span class="badge bg-danger ml-3">{{$new->unLikes_count}} Dislikes</span>
                                    </div>
                                        @php $l=0; $d=0; @endphp
                                        @foreach ($new->likes as $like)
                                                @if (Auth::user()->id === $like->user_id)
                                                    @php $l++; @endphp
                                                    @break
                                                @endif
                                        @endforeach

                                        @foreach ($new->dislikes as $dislike)
                                                @if (Auth::user()->id === $dislike->user_id)
                                                    @php $d++; @endphp
                                                    @break
                                                @endif
                                        @endforeach

                                        @if ($l>0)
                                            <span class="badge bg-info">Liked By You</span>
                                        @else
                                            <form style="display: inline" class="" action="{{route('news.like',['id' => $new->id])}}" method="POST">
                                                @csrf
                                                <button class="btn btn-info btn-sm" type="submit">Like
                                                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if ($d>0)
                                            <span class="badge bg-danger">DisLiked By You</span>
                                        @else
                                            <form style="display: inline" class="" action="{{route('news.unlike',['id' => $new->id])}}" method="POST">
                                                @csrf
                                                <button class="btn btn-danger btn-sm" type="submit">DisLike
                                                    <i class="fa fa-thumbs-down"></i>
                                                </button>
                                            </form>  
                                        @endif
                                   
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        @if (($new->comments_count === 0) || ($new->comments_count === 1))
                                            <span class="badge bg-primary">{{$new->comments_count}} comment</span>
                                        @else
                                            <span class="badge bg-primary">{{$new->comments_count}} comments</span>
                                        @endif
                                                 
                                    </div>
                                    <form action="{{route('news.comment',['news' => $new->id])}}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="comment" class="form-label fw-bold fs-4">Comment</label>
                                            <textarea class="form-control" name="content" @error('content') is-invalid @enderror  id="comment" rows="3"></textarea>
                                        </div>
                                        @error('content')
                                            <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-lg btn-primary" type="submit">Add Comment</button>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="card-footer text-muted">
                                    Updated {{$new->updated_at->diffForHumans()}}, by {{$new->user->name}} 
                                </div>
                            </div>
                        @empty
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    No News Added Yet
                                </div>
                            </div>    
                        @endforelse
                    </div>
                    @if ($news->count() > 0)
                    <div class="col-4 mx-auto">
                        <div class="card" style="width: 18rem;"> 
                            <div class="card-body">
                              <h5 class="card-title">Most News Liked</h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                @foreach ($mostLiked as $new)
                                    @if ($new->likes_count>0)
                                       <li class="list-group-item"><span class="badge bg-success">{{$new->likes_count}}</span> {{$new->title}}</li> 
                                    @endif               
                                @endforeach 
                            </ul>
                        </div><br>
                        <div class="card" style="width: 18rem;"> 
                            <div class="card-body">
                              <h5 class="card-title">Most News UnLiked</h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                @foreach ($mostDisliked as $new)
                                    @if($new->unLikes_count>0)
                                        <li class="list-group-item"><span class="badge bg-success">{{$new->unLikes_count}}</span> {{$new->title}}</li>
                                    @endif
                                @endforeach 
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
        </div>
    </div>
</x-app-layout>