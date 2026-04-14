@extends('layouts.app')

@section('title', 'Kelola Portofolio')
@section('page-title', 'Kelola Portofolio')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Content</a></li>
    <li class="breadcrumb-item active">Portofolio</li>
</ul>
@endsection

@section('content')
<div class="grid grid-cols-12 gap-x-6">
    <div class="col-span-12">
        <div class="card">

            {{-- Header --}}
            <div class="card-header !pb-0 !border-b-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="mb-1">Kelola Portofolio</h5>
                        <p class="text-sm text-muted">Kelola daftar portofolio website</p>
                    </div>

                    <a href="{{ route('portofolios.create') }}"
                       class="btn btn-primary flex gap-2">
                        <i class="fas fa-plus"></i>
                        Tambah Portofolio
                    </a>
                </div>
            </div>

            {{-- Alert --}}
            @if(session('success'))
            <div class="px-6 mt-4">
                <div class="alert-success flex items-center gap-3 p-4
                            text-white bg-gradient-to-tl from-green-600 to-emerald-400
                            rounded-lg shadow-sm">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
            @endif

            {{-- Table --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($portofolios as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="font-semibold">
                                    {{ $item->title }}
                                </td>

                                <td>
                                    {{ Str::limit(strip_tags($item->description), 60) }}
                                </td>

                                <td>
                                    @if($item->photo)
                                        <img src="{{ asset('storage/portofolios/'.$item->photo) }}"
                                             class="w-16 h-10 object-cover rounded">
                                    @else
                                        <span class="text-xs text-muted">No image</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="px-2 py-1 text-xs rounded-full text-white
                                        {{ $item->is_active ? 'bg-green-600' : 'bg-red-600' }}">
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('portofolios.edit', $item->portofolio_id) }}"
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('portofolios.destroy', $item->portofolio_id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus portofolio ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-muted">
                                    Data portofolio belum tersedia
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    @include('partials.admin.pagination', ['paginator' => $items->withQueryString()])

</div>
@endsection
