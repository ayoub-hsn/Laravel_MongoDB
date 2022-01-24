<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Archive') }}
        </h2>
    </x-slot>

    @if (Session::has('News_Restored'))
        <div class="alert alert-success">{{Session::get('News_Restored')}}</div>
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
                                        @can('restore',$new)
                                            <li>
                                                <form action="{{route('news.restore',['news' => $new->id])}}" method="POST">
                                                    @method('PATCH')
                                                    @csrf
                                                    <button class="dropdown-item" type="submit">Restore</button>
                                                </form>
                                            </li>
                                        @endcan
                                        @can('forceDelete',$new)
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{route('news.destroy',['news' => $new->id])}}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="dropdown-item" type="submit">Delete</button>
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
                                        <span class="badge bg-info mr-3">{{$new->likes->count()}} Likes</span>
                                        <span class="badge bg-danger ml-3">{{$new->dislikes->count()}} Dislikes</span>
                                    </div>
                                    <div class="mb-3">
                                        @if (($new->comments->count() === 0) || ($new->comments->count() === 1))
                                            <span class="badge bg-primary">{{$new->comments->count()}} comment</span>
                                        @else
                                            <span class="badge bg-primary">{{$new->comments->count()}} comments</span>
                                        @endif
                                                 
                                    </div>
                                </div>
                                
                                <div class="card-footer text-muted">
                                    Updated {{$new->updated_at->diffForHumans()}}, by {{$new->user->name}} 
                                </div>
                            </div>
                        @empty
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    No News Added Yet In Your Archive
                                </div>
                            </div>    
                        @endforelse
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>