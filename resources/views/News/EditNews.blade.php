<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit News') }}
        </h2>
    </x-slot>
    @if (Session::has('News_Updated'))
        <div class="alert alert-success">{{Session::get('News_Updated')}}</div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('news.update',['news' => $new->id])}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="picture" class="form-label">Picture</label>
                            <input type="file" name="picture" @error('picture') is-invalid @enderror class="form-control" id="picture">
                        </div>
                        @error('picture')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" value="{{old('title',$new->title)}}" @error('title') is-invalid @enderror class="form-control" id="title">
                        </div>
                        @error('title')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" name="content" value="" @error('content') is-invalid @enderror id="content" rows="3">{{old('content',$new->content)}}</textarea>
                        </div>
                        @error('content')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <div class="d-grid gap-2">
                            <button class="btn btn-lg btn-primary" type="submit">Edit News</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>