@extends('admin.main_design')

@section('update_category')
    @if (session('category_update'))
        <div
            class="relative mb-4 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700 dark:border-green-600 dark:bg-green-900 dark:text-green-200">
            {{ session('category_update') }}
        </div>
    @endif

    <div class="container-fluid">
        <form class="space-y-4" action="{{ route('update_category', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input class="w-full rounded border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" name="category"
                type="text" value="{{ old('category', $category->category) }}" placeholder="Enter Category Name!">
            <input
                class="cursor-pointer rounded border border-blue-600 bg-white px-4 py-2 font-bold text-blue-600 transition hover:bg-gray-200 dark:border-blue-400 dark:bg-gray-800 dark:text-blue-300 dark:hover:bg-gray-700"
                name="submit" type="submit" value="Update Category">
        </form>
    </div>
@endsection
