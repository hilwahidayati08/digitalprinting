@extends('admin.admin')

@section('title', 'Edit FAQ - Admin Panel')
@section('page-title', 'Edit FAQ')

@section('breadcrumbs')
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-primary-600">Dashboard</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <a href="{{ route('faqs.index') }}" class="text-sm text-gray-500 hover:text-primary-600">FAQ</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Edit</span>
                </div>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="w-full">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Edit FAQ</h2>
                <p class="text-sm text-gray-500">Perbarui informasi tanya jawab</p>
            </div>
            <a href="{{ route('faqs.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>

        <div class="p-6">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl">
                    <div class="flex items-center gap-2 text-red-800 font-bold mb-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Mohon perbaiki kesalahan berikut:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('faqs.update', $faq->faq_id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Pertanyaan</label>
                    <input type="text" name="question" value="{{ old('question', $faq->question) }}" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all outline-none"
                           placeholder="Masukkan pertanyaan...">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Jawaban</label>
                    <textarea name="answer" rows="5" 
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all outline-none"
                              placeholder="Masukkan jawaban lengkap...">{{ old('answer', $faq->answer) }}</textarea>
                </div>

                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" 
                                   {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </div>
                        <div class="ml-3">
                            <span class="text-sm font-bold text-gray-700">Aktifkan FAQ</span>
                            <p class="text-xs text-gray-500">FAQ akan langsung tampil di halaman depan website</p>
                        </div>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                    <a href="{{ route('faqs.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50 transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl shadow-md shadow-primary-200 transition-all font-bold text-sm flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        Update FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection