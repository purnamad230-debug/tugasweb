<?php

namespace App\Services;

use App\Models\Menu;
use Exception;
use Illuminate\Support\Facades\Log;

class MenuService
{
    /**
     * Menghapus menu berdasarkan ID.
     * * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteMenu($id)
    {
        // 1. Cari data terlebih dahulu
        $menu = Menu::find($id);

        // 2. Error Handling: Jika data tidak ditemukan
        if (!$menu) {
            throw new Exception("Data menu dengan ID {$id} tidak ditemukan.");
        }

        try {
            // 3. Proses hapus
            return $menu->delete();
            
        } catch (Exception $e) {
            // 4. Logging: Mencatat error ke file storage/logs/laravel.log 
            // Sangat berguna untuk debugging di server produksi
            Log::error("Gagal menghapus menu ID {$id}: " . $e->getMessage());
            
            throw new Exception("Terjadi kesalahan sistem saat menghapus data.");
        }
    }
}