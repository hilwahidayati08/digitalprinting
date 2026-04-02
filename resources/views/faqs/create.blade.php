@extends('layouts.app')

@section('title', 'Tambah FAQ')
@section('page-title', 'Tambah FAQ')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('faqs.index') }}">FAQ</a></li>
    <li class="breadcrumb-item">Tambah</li>
</ul>
@endsection

@section('content')

<div class="card">
    <div class="card-header flex justify-between">
        <h5>Tambah FAQ</h5>

        <a href="{{ route('faqs.index') }}" class="btn btn-outline-primary">
            Kembali
        </a>
    </div>

    <div class="card-body">

        @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('faqs.store') }}" method="POST">
            @csrf

            <div class="space-y-6">

                <div>
                    <label>Pertanyaan</label>
                    <input type="text" name="question" class="form-control" required>
                </div>

                <div>
                    <label>Jawaban</label>
                    <textarea name="answer" rows="5" class="form-control" required></textarea>
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="is_active" value="1" checked>
                        Aktifkan FAQ
                    </label>
                </div>

                <div class="pt-4">
                    <button class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="{{ route('faqs.index') }}" class="btn btn-outline-secondary">
                        Batal
                    </a>
                </div>

            </div>
        </form>

    </div>
</div>

@endsection
