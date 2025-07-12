@extends('admin.maindesign')

@section('view_category')
    <h1>View Categories</h1>
    @if(session('category_message'))
        <div class="alert alert-success">
            {{ session('category_message') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>

            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->category }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
