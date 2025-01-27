<x-app-layout>
    <x-slot name="header">
        <h2 >
            {{ __('Daily Work Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-5">
                        <h1 class="text-center">To-Do_List</h1>

                        <!-- Create Post Form -->
                        <div class="form-section">
                            <h4>Add Details</h4>
                            <form id="postForm">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Day</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter post title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Post Content</label>
                                    <textarea name="content" id="content" class="form-control" placeholder="Enter post content" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Work</button>
                            </form>
                        </div>

                        <!-- Display All Posts -->
                        <h2>All Work</h2>
                        <table class="table table-striped table-bordered text-black bg-white">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Details</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="postList">
                                @foreach($posts as $post)
                                    <tr id="post{{ $post->id }}">
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->content }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm editBtn" data-id="{{ $post->id }}">Edit</button>
                                            <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $post->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        // Create Post
        $('#postForm').on('submit', function(e) {
            e.preventDefault();
            let title = $('#title').val();
            let content = $('#content').val();

            $.ajax({
                url: "{{ route('posts.store') }}",
                method: 'POST',
                data: {
                    title: title,
                    content: content,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    alert(response.success);
                    $('#postList').append('<tr id="post' + response.id + '"><td>' + title + '</td><td>' + content + '</td><td><button class="btn btn-info btn-sm editBtn" data-id="' + response.id + '">Edit</button><button class="btn btn-danger btn-sm deleteBtn" data-id="' + response.id + '">Delete</button></td></tr>');
                    $('#title').val('');
                    $('#content').val('');
                }
            });
        });

        // Delete Post
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            $.ajax({
                url: '/posts/' + id,
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    alert(response.success);
                    $('#post' + id).remove();
                } 
            });
        });

        // Edit Post
        $(document).on('click', '.editBtn', function() {
            let id = $(this).data('id');
            $.ajax({
                url: '/posts/' + id,
                method: 'GET',
                success: function(response) {
                    $('#title').val(response.title);
                    $('#content').val(response.content);
                    $('#postForm').off('submit').on('submit', function(e) {
                        e.preventDefault();
                        let updatedTitle = $('#title').val();
                        let updatedContent = $('#content').val();

                        $.ajax({
                            url: '/posts/' + id,
                            method: 'PUT',
                            data: {
                                title: updatedTitle,
                                content: updatedContent,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                alert(response.success);
                                $('#post' + id).html('<td>' + updatedTitle + '</td><td>' + updatedContent + '</td><td><button class="btn btn-info btn-sm editBtn" data-id="' + id + '">Edit</button><button class="btn btn-danger btn-sm deleteBtn" data-id="' + id + '">Delete</button></td>');
                                $('#title').val('');
                                $('#content').val('');
                                $('#postForm').off('submit').on('submit', function(e) { /* Re-attach the create function */ });
                            }
                        });
                    });
                }
            });
        });
    });
</script>
