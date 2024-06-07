@extends('layout')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <h1>Post</h1>
    <form action="{{ route('posts.search') }}" method="GET">
        <div>
            <select name="category">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="tag">
                <option value="">Select Tag</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>

            <input class="search" type="text" name="title" placeholder="Search by title..."
                value="{{ request('title') }}">
            <button
                class="hidden xl:inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ml-1 sm:ml-3"
                type="submit">Search</button>
        </div>
    </form>
    <table border="solid">
        <thead>
            <tr>
                <th>
                    <a
                        href="{{ route('posts.search', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                        ID
                        @if (request('sort') == 'id')
                            @if (request('direction') == 'asc')
                                &#9650; <!-- Up arrow -->
                            @else
                                &#9660; <!-- Down arrow -->
                            @endif
                        @endif
                    </a>
                </th>
                <th>Title</th>
                <th style="width: 250px">Content</th>
                <th>Slug</th>
                <th>
                    <a
                        href="{{ route('posts.search', array_merge(request()->all(), ['sort' => 'date_updated', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                        Date Updated
                        @if (request('sort') == 'date_updated')
                            @if (request('direction') == 'asc')
                                &#9650; <!-- Up arrow -->
                            @else
                                &#9660; <!-- Down arrow -->
                            @endif
                        @endif
                    </a>
                </th>
                <th>Category</th>
                <th>Tags</th>
                <th>Author</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td class="img text-center"><img class="image" style="width: 250px" src="{{ $post->image }}"
                            alt="image"></td>
                    <td>{{ $post->slug }}</td>
                    <td>{{ $post->date_updated }}</td>
                    <td>
                        <ul>
                            @foreach ($post->categories as $category)
                                <li>{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                            @foreach ($post->tags as $tag)
                                <li>{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $post->author->name }}</td>
                    <td>
                        <div class="button-group" style="display: flex; justify-content:space-around">
                            <button class="edit" data-toggle="modal" data-target="#update{{ $post->id }}">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <form action="{{route('delete-post',['id' => $post->id])}}" method="GET">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="id" value="{{ $post->id }}">
                            <button class="delete" type="submit" onclick="return confirm('Apakah anda yakin untuk menghapus postingan ini?')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                              </svg></button>
                        </form>
                        </div>
                        
                        <div class="modal fade" id="update{{ $post->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel{{ $post->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel{{ $post->id }}">Update Data</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('update-post', ['id' => $post->id]) }}" method="POST"
                                        class="main">
                                        <div class="modal-body" style="width: 100%">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input class="form-control" type="text" id="title" name="title"
                                                    value="{{ $post->title }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="image">Image URL</label>
                                                <input class="form-control" type="text" id="image" name="image"
                                                    value="{{ $post->image }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="slug">Slug</label>
                                                <input class="form-control" type="text" id="slug" name="slug"
                                                    value="{{ $post->slug }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="categories">Categories (comma separated)</label>
                                                <input class="form-control" type="text" id="categories" name="categories" value="{{ $post->categories->pluck('name')->implode(', ') }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="tags">Tags (comma separated)</label>
                                                <input class="form-control" type="text" id="tags" name="tags" value="{{ $post->tags->pluck('name')->implode(', ') }}">
                                            </div>


                                            <div class="form-group">
                                                <label for="author">Author</label>
                                                <select name="author" id="author"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option value="1" {{ $post->author_id == 1 ? 'selected' : '' }}>
                                                        Lina Stock</option>
                                                    <option value="2" {{ $post->author_id == 2 ? 'selected' : '' }}>
                                                        Heather Halpern</option>
                                                    <option value="3" {{ $post->author_id == 3 ? 'selected' : '' }}>
                                                        David Stock</option>
                                                    <option value="4" {{ $post->author_id == 4 ? 'selected' : '' }}>
                                                        Guest Writer</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div style="width:100%" class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {{ $posts->links() }}

    <script>
        $('#update').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-body input').val(recipient)
        })
    </script>
@endsection
