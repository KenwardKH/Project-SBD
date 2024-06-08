@extends('layout')

@section('title', 'Tags')

@section('page-title', 'Dashboard')

@section('content')
    <h1>Tag Table</h1>
    <table>
        <thead style="text-align: center">
            <th><a href="{{ route('tags.index', ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">ID</a></th>
            <th><a href="{{ route('tags.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">Category Name</a></th>
            <th><a href="{{ route('tags.index', ['sort' => 'posts_count', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">Post Count</a></th>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->posts_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
