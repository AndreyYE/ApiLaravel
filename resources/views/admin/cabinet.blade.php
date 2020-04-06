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
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($admin))
                    <tr>
                        <th scope="row">{{$admin->id}}</th>
                        <th scope="row">{{$admin->name}}</th>
                        <th scope="row">{{$admin->email}}</th>
                        <th scope="row">{{$admin->created_at}}</th>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection