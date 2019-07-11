@extends('layouts.frontend')

@section('content')
    @foreach ($posts as $post)
        <div class="post-preview">
            <a href='{{ url("/view/".$post["_id"]) }}'>
            <h2 class="post-title">
                {{ $post['title'] }}
            </h2>
            <p class="post-subtitle">
                {{ $post['summary'] }}
            </p>
            </a>
            <p class="post-meta">Posted on {{ $post['published_at']->toDateTime()->format('d/m/Y H:i') }}</p>
        </div>
        <hr>
    @endforeach
@endsection
