<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Services::latest()->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'icon'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['is_active'] = $request->has('is_active');

        // upload icon
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('storage/services'), $filename);
            $data['icon'] = $filename;
        }

        Services::create($data);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service berhasil ditambahkan');
    }

    public function edit(Services $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Services $service)
    {
        $data = $request->validate([
            'service_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'icon'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['is_active'] = $request->has('is_active');

        // upload icon baru
        if ($request->hasFile('icon')) {

            // hapus icon lama
            if ($service->icon && file_exists(public_path('storage/services/'.$service->icon))) {
                unlink(public_path('storage/services/'.$service->icon));
            }

            $file = $request->file('icon');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('storage/services'), $filename);
            $data['icon'] = $filename;
        }

        $service->update($data);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service berhasil diperbarui');
    }
    /**
     * Hapus service
     */
    public function destroy($id)
    {
        $service = Services::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service berhasil dihapus');
    }
}