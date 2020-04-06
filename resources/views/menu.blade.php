<?php $route = explode('.',Route::currentRouteName())?>
@if($route[0] == 'admin' && ($route[1] != 'register' && $route[1] != 'login'))
<ul class="nav nav-pills justify-content-center">
    <li class="nav-item">
        <a class="nav-link {{Route::currentRouteName()=='admin.cabinet'?'active':''}}" href="{{route('admin.cabinet')}}">Cabinet</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Route::currentRouteName()=='admin.categories.index' ||
        Route::currentRouteName()=='admin.categories.create' ||
        Route::currentRouteName()=='admin.categories.show' ||
        Route::currentRouteName()=='admin.categories.edit'
        ?'active':''}}" href="{{route('admin.categories.index')}}">Categorise</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Route::currentRouteName()=='admin.users'||
        Route::currentRouteName()=='admin.user'
        ?'active':''}}" href="{{route('admin.users')}}">Users</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Route::currentRouteName()=='admin.posts'||
        Route::currentRouteName()=='admin.post'
        ?'active':''}}" href="{{route('admin.posts')}}">Posts</a>
    </li>
</ul>
@endif