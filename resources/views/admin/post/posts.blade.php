@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 ">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Text</th>
                        <th scope="col">Created_at</th>
                        <th scope="col">Info</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($posts))
                    @foreach($posts as $post)
                    <tr>
                        <th scope="row">{{$post->id}}</th>
                        <th scope="row">{{$post->name}}</th>
                        <th scope="row">{{\Illuminate\Support\Str::limit($post->text,20,' ...')}}</th>
                        <th scope="row">{{$post->created_at}}</th>
                        <td><a class="btn btn-success" role="button" href="{{route('admin.post',['post'=>$post->id])}}">Info</a></td>
                    </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
                {{ $posts->links() }}
        </div>
    </div>
@endsection