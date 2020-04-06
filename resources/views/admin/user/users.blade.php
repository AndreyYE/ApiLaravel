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
                        <th scope="col">E-mail</th>
                        <th scope="col">Created_at</th>
                        <th scope="col">Info</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($users))
                    @foreach($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <th scope="row">{{$user->name}}</th>
                        <th scope="row">{{$user->email}}</th>
                        <th scope="row">{{$user->created_at}}</th>
                        <td><a class="btn btn-success" role="button" href="{{route('admin.user',['user'=>$user->id])}}">Info</a></td>
                    </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
                {{ $users->links() }}
        </div>
    </div>
@endsection