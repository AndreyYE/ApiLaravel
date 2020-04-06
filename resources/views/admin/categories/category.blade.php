@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12"><a class="btn btn-danger" role="button" href="{{route('admin.categories.index')}}">Go Back</a></div>
            <div class="col-12 ">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Add Category</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($category))
                    <tr>
                        <th scope="row">{{$category->id}}</th>
                        <td>
                            {{$category->name}}
                        </td>
                        <td><a class="btn btn-success" role="button" href="{{route('admin.categories.create',['category'=>$category->id])}}">Add</a></td>
                        <td><a class="btn btn-primary" role="button" href="{{route('admin.categories.edit',['category'=>$category->id])}}">Edit</a></td>
                        <td>
                            <form method="POST" action="{{route('admin.categories.destroy',['category'=>$category->id])}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection