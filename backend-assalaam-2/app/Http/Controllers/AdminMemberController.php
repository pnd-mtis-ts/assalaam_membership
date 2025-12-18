<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    /**
     * Tampilkan daftar member
     * (nama, nomor member, status aktivasi, validasi, dan masa aktif)
     */
    public function index()
    {
        $members = Member::select(
            'MEMBER_ID',
            'MEMBER_NAME',
            'MEMBER_CARD_NO',
            'MEMBER_IS_ACTIVE',
            'MEMBER_IS_VALID',
            'MEMBER_ACTIVE_TO' // pastikan ini sesuai di DB
        )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $members,
        ]);
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);

        return response()->json(['success' => true, 'data' => $member]);
    }

    /**
     * Update status aktivasi member saja
     */
    public function updateActivation(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'MEMBER_IS_ACTIVE' => 'required|boolean',
        ]);

        $member->MEMBER_IS_ACTIVE = $request->MEMBER_IS_ACTIVE;

        // Tentukan masa aktif otomatis jika aktif dan belum ada tanggal
        if ($member->MEMBER_IS_ACTIVE == 1 && empty($member->MEMBER_ACTIVE_TO)) {
            $member->MEMBER_ACTIVE_TO = Carbon::now()->addYear();
        }

        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'Status aktivasi member berhasil diperbarui',
            'data' => $member,
        ]);
    }

    /**
     * Update status validasi member saja
     */
    public function updateValidation(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'MEMBER_IS_VALID' => 'required|boolean',
        ]);

        $member->MEMBER_IS_VALID = $request->MEMBER_IS_VALID;

        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'Status validasi member berhasil diperbarui',
            'data' => $member,
        ]);
    }
}
