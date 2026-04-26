<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Services\MenuService;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * 1. Tampilkan Data (READ)
     */
    public function index()
    {
        try {
            $menus = Menu::all();

            return response()->json([
                'message' => 'Data menu berhasil diambil',
                'data' => $menus
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengambil data menu',
                'detail' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 2. Tambah Data (CREATE)
     */
    public function store(Request $request)
    {
        // VALIDASI
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0'
        ]);

        try {
            // PANGGIL SERVICE
            $menu = $this->menuService->create($validated);

            return response()->json([
                'message' => 'Data berhasil ditambahkan',
                'data' => $menu
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal menambahkan data',
                'detail' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 3. Ubah Data (UPDATE)
     */
    public function update(Request $request, $id)
    {
        // VALIDASI
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0'
        ]);

        try {
            $menu = Menu::findOrFail($id);

            $menu->update($validated);

            return response()->json([
                'message' => 'Data berhasil diubah',
                'data' => $menu
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengubah data',
                'detail' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 4. Hapus Data (DELETE)
     */
    public function destroy($id)
    {
    // Cek otorisasi
    if (Gate::denies('admin-only')) {
        return response()->json(['message' => 'Hanya Admin yang bisa menghapus!'], 403);
    }
    // Jika admin, panggil service untuk hapus
    $this->menuService->delete($id);
    return response()->json(['message' => 'Data terhapus']);
        try {
            $menu = Menu::findOrFail($id);

            $menu->delete();

            return response()->json([
                'message' => 'Data berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal menghapus data',
                'detail' => $e->getMessage()
            ], 500);
        }
    }
}