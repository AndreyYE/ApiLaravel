@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12"><a class="btn btn-danger" role="button" href="{{route('admin.categories.index')}}">Go Back</a></div>
            <div class="col">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.categories.update',['category'=>$category->id]) }}">
                    {{ csrf_field() }}
                    @method('PUT')

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name',$category->name) }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    @if($categories)
                        <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                            <label for="parent_id" class="col-md-4 control-label">Родительская категория</label>
                                <div class="col-md-6">
                                    <select name="parent_id" id="parent_id">
                                        <option value="0">Категория не выбрана</option>
                                        @foreach($categories as $value)
                                        <option {{old('parent_id')==$value->id?'selected':$category->parent_id==$value->id?'selected':''}} value="{{$value->id}}">
                                            @if($value->depth)
                                                @for($i=0;$i<$value->depth;$i++)
                                                    -
                                                @endfor
                                            @endif
                                            {{$value->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            @if ($errors->has('parent_id'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Edit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection