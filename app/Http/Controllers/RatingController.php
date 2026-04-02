<?php

namespace App\Http\Controllers;

use App\Models\Ratings;
use App\Models\OrderItems;
use App\Models\Orders; // Tambahkan ini
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id'   => 'required|exists:orders,order_id',
            'product_id' => 'required|exists:products,product_id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:1000'
        ]);

        // Cek apakah order ini milik user yang login
        // dan produk ini memang ada di order tersebut
        $validOrder = Orders::where('order_id', $request->order_id)
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })
            ->exists();

        if (!$validOrder) {
            return back()->with('error', 'Order tidak valid atau belum selesai.');
        }

        // Cek apakah order ini sudah pernah dirating untuk produk ini
        $sudahRating = Ratings::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            ->exists();

        if ($sudahRating) {
            return back()->with('error', 'Anda sudah memberikan rating untuk order ini.');
        }

        Ratings::create([
            'user_id'    => auth()->id(),
            'product_id' => $request->product_id,
            'order_id'   => $request->order_id,
            'rating'     => $request->rating,
            'review'     => $request->comment
        ]);

        return back()->with('success', 'Terima kasih atas review Anda!');
    }

}