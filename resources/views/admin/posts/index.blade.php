@extends ('layouts.backend')

@section('title')
    {{ __('messages.allPosts') }}
@endsection

@section('content')
<table class="table" style="background: #FFF">

  <thead>
    <tr>
      <th scope="col" width="5%">#</th>
      <th scope="col" width="60%">Title</th>
      <th scope="col">Published at</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($posts as $post)
        <tr>
            <td><input type="checkbox" name="id" value="{{ $post['_id'] }}"></td>
            @if ($post['is_published'])
                <td><a target="_blank" href='{{ url("/view/" . $post["_id"]) }}' title='{{ __("messages.clickToView") }}'>{{ $post['title'] }}</a></td>
            @else
                <td>{{ $post['title'] }}</td>
            @endif
            <td>{{ empty($post['published_at']) ? '' : $post['published_at']->toDateTime()->format('d/m/Y H:i') }}</td>
            <td>
                <a href='{!! url("/admin/posts/{$post['_id']}/edit") !!}'>Edit</a> | 
                <a href='{!! url("/admin/posts/{$post['_id']}") !!}' class="delete_post">Delete</a>
            </td>
        </tr>
    @endforeach
  </tbody>
</table>
<script>
(function IndexPostPage() {
    window.onload = function() {
        $(document).on('click', '.delete_post', function() {
            if (confirm('Are you sure you want to delete this post?')) {
                var url = $(this).attr('href');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function(res) {
                        location.reload();
                    }
                });
            }
            return false;
        });
    }
})();
</script>
@endsection