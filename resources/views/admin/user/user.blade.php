@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12"><a class="btn btn-success btn-lg mb-3" role="button" href="{{route('admin.users')}}">Go Back</a></div>
            <div class="col-12 ">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Created_at</th>
                        <th scope="col">Quantity posts</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($user))
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <th scope="row">{{$user->name}}</th>
                        <th scope="row">{{$user->email}}</th>
                        <th scope="row">{{$user->created_at}}</th>
                        <th scope="row">{{$user->posts_count}}</th>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection