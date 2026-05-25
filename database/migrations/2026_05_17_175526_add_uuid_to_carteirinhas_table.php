<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carteirinhas', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->nullable()->after('id');
        });

        // OPICIONAL: Preenche o UUID para as carteirinhas que JÁ existem no banco
        // Preenche o UUID para as carteirinhas que JÁ existem no banco
        DB::table('carteirinhas')
            ->whereNull('uuid')
            ->orderBy('id')
            ->chunkById(200, function ($carteirinhas) {
                foreach ($carteirinhas as $carteirinha) {
                    DB::table('carteirinhas')
                        ->where('id', $carteirinha->id)
                        ->update(['uuid' => (string) Str::uuid()]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('carteirinhas', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
