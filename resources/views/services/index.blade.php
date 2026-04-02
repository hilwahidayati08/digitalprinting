@extends('layouts.app')

@section('title', 'Kelola Service')
@section('page-title', 'Kelola Service')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript: void(0)">Content</a></li>
    <li class="breadcrumb-item" aria-current="page">Service</li>
</ul>
@endsection

@section('content')
<div class="grid grid-cols-12 gap-x-6">
    <div class="col-span-12">
        <div class="card">
            <div class="card-header !pb-0 !border-b-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h5>Kelola Service</h5>
                        <p class="text-sm text-muted mt-1">Kelola service website</p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('services.create') }}"
                           class="btn btn-primary flex items-center gap-2">
                            <i class="fas fa-plus text-sm"></i>
                            <span>Tambah Service</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Alert --}}
            @if(session('success'))
            <div class="px-6 mt-4">
                <div class="alert-success flex items-center gap-3 p-4 mb-4 text-white bg-gradient-to-tl from-green-600 to-emerald-400 rounded-lg shadow-sm">
                    <i class="text-lg fas fa-check-circle"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Service</th>
                                <th>Logo</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <h6 class="mb-0 text-sm font-semibold">
                                        {{ $service->service_name }}
                                    </h6>
                                </td>
                                <td>
                                    @if ($service->icon)
                                        <img src="{{ asset('storage/services/'.$service->icon) }}"
                                            class="h-12 rounded">
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $service->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('services.edit', $service->service_id) }}"
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('services.destroy', $service->service_id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus Service ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-400">
                                    Belum ada Service
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection