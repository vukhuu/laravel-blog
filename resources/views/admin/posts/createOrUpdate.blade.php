@extends ('layouts.backend')

@section('title')
    @if ($isCreateNew)
        {{ __('messages.createPost') }}
    @else
    {{ __('messages.updatePost') }}
    @endif
@endsection

@section('content')
<div class="col-xl-12 col-md-6 mb-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <form id="form_post" method="POST">
        @if ($isCreateNew === false)
            {{ method_field('PUT') }}
        @endif

        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Title" value="{{ old('title', $post->title) }}" name="title">
        </div>
        <div class="form-group">
            <label for="summary">Summary</label>
            <textarea class="form-control" id="summary" name="summary" placeholder="Summary" rows="5">{{ old('summary', $post->summary) }}</textarea>
        </div>
        <div class="form-group">
            <label for="detail">Detail</label>
            <textarea class="form-control" id="detail" name="detail" placeholder="Detail">{{ old('detail', $post->detail) }}</textarea>
        </div>
        <div class="hidden">
            <input type="hidden" id="is_published" name="is_published" value="{{ $post->is_published }}">
        </div>

        @if ($isCreateNew)
            <button type="button" class="btn" id="btn_save">Save draft</button>
            <button type="button" class="btn btn-primary" id="btn_publish">Publish</button>
        @else
            @if ($post->is_published == \App\Post::IS_PUBLISHED_YES)
                <button type="button" class="btn btn-primary" id="btn_update">Update</button>
            @else
                <button type="button" class="btn" id="btn_update">Update</button>
                <button type="button" class="btn btn-primary" id="btn_publish">Publish</button>
            @endif
        @endif
    </form>
</div>

<script>
(function CreatePostPage() {
    var saveUrl = '{{ url('/admin/posts/store') }}';
    var saveUrlWithPublish = saveUrl + '/1';
    var updateUrl = '{{ url("/admin/posts/{$post->_id}/update") }}';
    var updateUrlWithPublish = updateUrl + '/1';
    window.onload = function() {
        $('#detail').summernote({height: 300});
        $('#btn_save').click(function() {
            $('#form_post').attr('action', saveUrl);
            $('#form_post').submit();
        });
        $('#btn_publish').click(function() {
            @if ($isCreateNew)
                $('#form_post').attr('action', saveUrlWithPublish);
            @else
                $('#form_post').attr('action', updateUrlWithPublish);
            @endif

            $('#form_post').submit();
        });
        $('#btn_update').click(function() {
            $('#form_post').attr('action', updateUrl);
            $('#form_post').submit();
        });
    }
})();
</script>
@endsection