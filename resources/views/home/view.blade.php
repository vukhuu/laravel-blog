@extends('layouts.frontend')

@section('title')
    {{ $post['title'] }}
@endsection

@section('content')
    <div class="post-preview">
        <h2 class="post-title">
            {{ $post['title'] }}
        </h2>
        <p class="post-subtitle">
            {{ $post['summary'] }}
        </p>
        <p class="post-meta">Posted on {{ $post['published_at']->format('d/m/Y H:i') }}</p>
        <p>{!! $post->detail !!}</p>
    </div>
    <button type="button" class="btn btn-primary" onclick="js:window.history.back()">Back</button>
@endsection
