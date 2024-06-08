@extends('welcome')

@section('content')
    <div class="home-product">
        <div class="container">
            @php
                echo html_entity_decode($blog->content);
            @endphp
        </div>
    </div>
@endsection
