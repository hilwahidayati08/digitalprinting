@php
    $paginator = $paginator ?? $orders ?? $products ?? $items ?? $users ?? $data ?? null;
    $isPaginator = $paginator instanceof \Illuminate\Pagination\LengthAwarePaginator;
@endphp

@if($isPaginator && $paginator->hasPages())
<div class="px-6 py-3 border-t border-gray-100 flex items-center gap-2">

    {{-- Total items --}}
    <span class="text-xs text-gray-400 mr-2">{{ $paginator->total() }} items</span>

    {{-- First --}}
    @if($paginator->onFirstPage())
        <span class="pagination-btn disabled">«</span>
    @else
        <a href="{{ $paginator->url(1) }}" class="pagination-btn">«</a>
    @endif

    {{-- Prev --}}
    @if($paginator->onFirstPage())
        <span class="pagination-btn disabled">‹</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn">‹</a>
    @endif

    {{-- Current of Last --}}
    <span class="text-xs text-gray-600 font-bold px-1">
        {{ $paginator->currentPage() }}
    </span>
    <span class="text-xs text-gray-400">dari {{ $paginator->lastPage() }}</span>

    {{-- Next --}}
    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn active">›</a>
    @else
        <span class="pagination-btn disabled">›</span>
    @endif

    {{-- Last --}}
    @if($paginator->currentPage() == $paginator->lastPage())
        <span class="pagination-btn disabled">»</span>
    @else
        <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination-btn">»</a>
    @endif

</div>

<style>
    .pagination-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 12px;
        color: #64748b;
        background: #fff;
        text-decoration: none;
        transition: all 0.15s;
    }
    .pagination-btn:hover {
        border-color: #94a3b8;
        color: #1e293b;
    }
    .pagination-btn.disabled {
        color: #cbd5e1;
        cursor: not-allowed;
        background: #f8fafc;
    }
    .pagination-btn.active {
        border-color: #3b82f6;
        color: #3b82f6;
    }
</style>
@endif