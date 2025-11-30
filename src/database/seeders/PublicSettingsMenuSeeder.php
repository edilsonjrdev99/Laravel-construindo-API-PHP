<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicSettingsMenuSeeder extends Seeder {
    /**
     * Responsável por executar a seeder
     */
    public function run(): void {
        DB::table('public_settings_menu')->insert([
            [
                'name'       => 'produtos',
                'title'      => 'Products',
                'path'       => '/',
                'link'       => '/produtos',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'categorias',
                'title'      => 'Categorias',
                'path'       => '/',
                'link'       => '/categorias',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'promocoes',
                'title'      => 'Promoções',
                'path'       => '/',
                'link'       => '/promocoes',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}