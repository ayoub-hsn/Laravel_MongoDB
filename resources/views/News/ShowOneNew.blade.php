<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All News') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="row">
                    <div class="col-6 mx-auto">
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
                                    <div class="">
                                        <span class="badge bg-info">{{$new->likes->count()}} Likes</span>
                                        <span class="badge bg-danger">{{$new->dislikes->count()}} Dislikes</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        @if (($new->comments->count() === 0) || ($new->comments->count() === 1))
                                            <span class="badge bg-primary">{{$new->comments->count()}} comment</span>
                                        @else
                                            <span class="badge bg-primary">{{$new->comments->count()}} comments</span>
                                        @endif
                                                 
                                    </div>
                                        
                                        <label for="comment" class="form-label fw-bold fs-4">Comments</label><br> 
                                       
                                        @foreach ($new->comments as $comment)
                                            <p style="display: inline" class="fw-bold fs-8 text-white bg-info pl-3 pr-3">{{$comment->user->name}}</p> : 
                                            <p style="display: inline" class="fw-bold fs-8 text-secondary">{{$comment->content}}</p><br>
                                        @endforeach
                                </div>
                                
                                <div class="card-footer text-muted">
                                    Updated {{$new->updated_at->diffForHumans()}}, by {{$new->user->name}} 
                                </div>
                            </div>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>