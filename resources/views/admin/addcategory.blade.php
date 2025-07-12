@extends('admin.maindesign')

@section('add_category')
    @if (session('category_message'))
        <div
            class="relative mb-4 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700 dark:border-green-600 dark:bg-green-900 dark:text-green-200">
            {{ session('category_message') }}
        </div>
    @endif

    @if ($errors->any())
        <div
            class="relative mb-4 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700 dark:border-red-600 dark:bg-red-900 dark:text-red-200">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid">
        <form class="space-y-4" action="{{ route('postaddcategory') }}" method="POST">
            @csrf
            <input class="w-full rounded border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" name="category"
                type="text" value="{{ old('category') }}" placeholder="Enter Category Name!">
            <input
                class="cursor-pointer rounded border border-blue-600 bg-white px-4 py-2 font-bold text-blue-600 transition hover:bg-gray-200 dark:border-blue-400 dark:bg-gray-800 dark:text-blue-300 dark:hover:bg-gray-700"
                name="submit" type="submit" value="Add Category">
        </form>
    </div>
@endsection
