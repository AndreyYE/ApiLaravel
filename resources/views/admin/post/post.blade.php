@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12"><a class="btn btn-success btn-lg mb-3" role="button" href="{{route('admin.posts')}}">Go Back</a></div>
            <div class="col-12 ">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Text</th>
                        <th scope="col">Image</th>
                        <th scope="col">Category</th>
                        <th scope="col">Author</th>
                        <th scope="col">Created_at</th>
                        <th scope="col">Quantity favorites</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($post))
                    <tr>
                        <th scope="row">{{$post->id}}</th>
                        <th scope="row">{{$post->name}}</th>
                        <th scope="row">{{$post->text}}</th>
                        <th scope="row"><img style="height: 100px; width: 100px" src="{{ asset('storage/'.$post->image) }}" alt="noImage" title=""></th>
                        <th scope="row">{{$post->category->name}}</th>
                        <th scope="row">{{$post->user->name}}</th>
                        <th scope="row">{{$post->created_at}}</th>
                        <th scope="row">{{$post->favorites_count}}</th>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection