<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('event_types')->insert([
            [
                'id' => 1,
                'name' => 'Missas Semanais',
                'image' => 'https://media-cdn.tripadvisor.com/media/photo-p/0c/4e/2e/b6/muito-bonita-a-igreja.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Liturgia',
                'image' => 'https://img.cancaonova.com/cnimages/canais/uploads/sites/6/2002/05/formacao_liturgia-a-alma-da-igreja-1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Festas Religiosas',
                'image' => 'https://portalteofilootoni.com.br/wp-content/uploads/2024/08/Captura-de-tela-2024-08-02-182428.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Eventos Especiais',
                'image' => 'https://s2-g1.glbimg.com/aMOwIycSLD5b3iuKq66jBebYREI=/0x0:1500x999/1008x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_59edd422c0c84a879bd37670ae4f538a/internal_photos/bs/2022/4/M/KPcDG9RKyAicejucJ6aw/9ad307d4b7fd3355e4e42fdc41c8d7d9.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Missas Semanais',
                'image' => 'https://media-cdn.tripadvisor.com/media/photo-p/0c/4e/2e/b6/muito-bonita-a-igreja.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'Liturgia',
                'image' => 'https://img.cancaonova.com/cnimages/canais/uploads/sites/6/2002/05/formacao_liturgia-a-alma-da-igreja-1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => 'Festas Religiosas',
                'image' => 'https://portalteofilootoni.com.br/wp-content/uploads/2024/08/Captura-de-tela-2024-08-02-182428.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'name' => 'Eventos Especiais',
                'image' => 'https://s2-g1.glbimg.com/aMOwIycSLD5b3iuKq66jBebYREI=/0x0:1500x999/1008x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_59edd422c0c84a879bd37670ae4f538a/internal_photos/bs/2022/4/M/KPcDG9RKyAicejucJ6aw/9ad307d4b7fd3355e4e42fdc41c8d7d9.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
