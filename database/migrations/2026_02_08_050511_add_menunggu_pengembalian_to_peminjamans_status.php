<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE peminjamans 
            MODIFY status ENUM(
                'menunggu',
                'disetujui',
                'ditolak',
                'dipinjam',
                'menunggu_pengembalian',
                'dikembalikan'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE peminjamans 
            MODIFY status ENUM(
                'menunggu',
                'disetujui',
                'ditolak',
                'dipinjam',
                'dikembalikan'
            ) NOT NULL
        ");
    }
};
