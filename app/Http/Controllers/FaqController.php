<?php

namespace App\Http\Controllers;

use App\Models\Faqs;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // 1. Ambil query pencarian dari input 'search'
    $search = $request->input('search');

    // 2. Query data dengan filter jika ada pencarian
    $faqs = Faqs::when($search, function ($query, $search) {
            return $query->where('question', 'like', "%{$search}%")
                         ->orWhere('answer', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
        ->paginate(5) // Gunakan paginate agar sesuai dengan tampilan materials
        ->withQueryString(); // Menjaga parameter search tetap ada saat pindah halaman

    // 3. Sesuaikan path view dengan folder admin (admin/faqs/index.blade.php)
    return view('faqs.index', compact('faqs'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        Faqs::create([
            'question'  => $request->question,
            'answer'    => $request->answer,
            'is_active' => $request->has('is_active') ? true : false,
        ]);



        return redirect()->route('faqs.index')->with('success', 'FAQ berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit($id)
{
    $faq = Faqs::where('faq_id', $id)->firstOrFail();
    return view('faqs.edit', compact('faq'));
}

public function update(Request $request, $id)
{
    $faq = Faqs::where('faq_id', $id)->firstOrFail();
    
    $request->validate([
        'question' => 'nullable|string|max:255',
        'answer' => 'nullable|string',
    ]);

    $faq->update([
        'question'  => $request->question,
        'answer'    => $request->answer,
        'is_active' => $request->has('is_active') ? true : false,
    ]);

    return redirect()->route('faqs.index')->with('success', 'FAQ berhasil diperbarui!');
}

    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    // Cari data berdasarkan ID (sesuaikan primary key Anda, di view Anda menggunakan faq_id)
    $faq = Faqs::where('faq_id', $id)->firstOrFail();
    
    $faq->delete();

    return redirect()->route('faqs.index')->with('success', 'FAQ berhasil dihapus');
}
}
