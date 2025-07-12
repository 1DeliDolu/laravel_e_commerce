@extends('admin.maindesign')

@section('view_category')

    {{-- Başarı mesajı --}}
    @if (session('category_message'))
        <div class="alert alert-success">
            {{ session('category_message') }}
        </div>
    @endif

    {{-- Hata mesajları --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tablo container --}}
    <div class="container-fluid px-0"> {{-- Kenar boşluklarını kaldırdık --}}
        <div class="table-responsive">
            <table class="table-striped table-bordered w-100 table" style="width: 100%;">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th class="text-end">Actions</th> {{-- Sağ hizalama --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category }}</td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center" style="gap: 10px;">
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('updatecategoryform', $category->id) }}">
                                        Update
                                    </a>
                                    <form class="mb-0" action="{{ route('deletecategory', $category->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
