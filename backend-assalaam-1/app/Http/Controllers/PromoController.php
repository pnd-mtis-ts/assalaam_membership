<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PromoController extends Controller
{
    
    public function index()
    {
        try {
            Promo::whereDate('tanggal_berakhir', '<', Carbon::today())->each(function ($promo) {
                if (Storage::disk('public')->exists($promo->path)) {
                    Storage::disk('public')->delete($promo->path);
                }
                $promo->delete();
            });

            $promos = Promo::orderByDesc('created_at')->get();

            return response()->json([
                'success' => true,
                'data' => $promos,
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat mengambil daftar promo: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil daftar promo.',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:webp,jpg,png,jpeg|max:2048',
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'tanggal_berakhir' => 'required|date|after_or_equal:today',
            ]);

            $path = $request->file('image')->store('promo', 'public');

            $promo = Promo::create([
                'path' => $path,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'tanggal_berakhir' => $request->tanggal_berakhir,
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Promo berhasil ditambahkan.',
                'data' => $promo,
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan promo: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan promo.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $promo = Promo::findOrFail($id);

            if (Storage::disk('public')->exists($promo->path)) {
                Storage::disk('public')->delete($promo->path);
            }

            $promo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Promo berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat menghapus promo: '.$e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus promo.',
            ], 500);
        }
    }
}