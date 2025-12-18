<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    // Tampilkan halaman pengaturan
    public function index()
    {
        $minimalPoin = DB::table('settings')->where('key', 'minimal_poin')->value('value');
        return view('settings.index', compact('minimalPoin'));
    }

    // Update minimal poin
    public function update(Request $request)
    {
        $request->validate([
            'minimal_poin' => 'required|integer|min:0'
        ]);

        DB::table('settings')->updateOrInsert(
            ['key' => 'minimal_poin'],
            ['value' => $request->minimal_poin, 'updated_at' => now()]
        );

        return redirect()->back()->with('success', 'Minimal poin berhasil diupdate');
    }
}
