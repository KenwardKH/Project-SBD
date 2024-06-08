@extends('layout')

@section('title', 'Categories')

@section('page-title', 'Dashboard')

@section('content')
    <h1>Category Table</h1>
    <table>
        <thead style="text-align: center">
            <th><a href="{{ route('categories.index', ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">ID</a></th>
            <th><a href="{{ route('categories.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">Category Name</a></th>
            <th><a href="{{ route('categories.index', ['sort' => 'posts_count', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">Post Count</a></th>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->posts_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
