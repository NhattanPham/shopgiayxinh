@extends('backend.master')

@section('title','File')

@section('content')
    <div class="container-box">
        <div class="wrapper-box">
           <iframe style="width: 100%;height: 800px" src="{{url('admin/laravel-filemanager')}}" frameborder="0"></iframe>
        </div>
    </div>
@endsection