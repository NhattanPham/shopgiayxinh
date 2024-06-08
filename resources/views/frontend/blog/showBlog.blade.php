@extends('welcome')

@section('content')
    <div class="home-product">
        <div class="container">
            <div class="list-blog">
                @foreach ($blogs as $blog)
                    <div class="item-blog">
                        <a href="{{ url('blog/'.$blog->slug.'.html')}}">
                            <h2>{{ $blog->title }}</h2>
                            <img src="{{ asset($blog->thumbnail) }}" alt="Not found">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
