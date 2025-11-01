<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->nullable()->after('name');
            $table->string('corporate_name')->nullable()->after('surname');
            $table->string('phone')->nullable()->after('corporate_name');
            $table->enum('person_type', ['fisica', 'juridica'])->default('fisica')->after('phone');
            $table->string('cpf', 11)->nullable()->after('person_type');
            $table->string('cnpj', 14)->nullable()->after('cpf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['surname', 'corporate_name', 'phone', 'person_type', 'cpf', 'cnpj']);
        });
    }
};
