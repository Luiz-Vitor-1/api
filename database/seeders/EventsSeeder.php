<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'id' => 2,
                'title' => 'Corpus Christi',
                'subtitle' => 'Celebração da Eucaristia',
                'start_date' => Carbon::create('2024', '05', '30', '16', '00', '00'),
                'end_date' => Carbon::create('2024', '05', '30', '16', '00', '00'),
                'time' => '16:00:00',
                'description' => 'Participe da celebração que renova nossa conexão espiritual.',
                'location' => 'Catedral Imaculada Conceição',
                'type_event_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'title' => 'Missas de Domingo',
                'subtitle' => 'Celebração dominical',
                'start_date' => Carbon::create('2024', '09', '29', '10', '00', '00'),
                'end_date' => Carbon::create('2024', '09', '29', '10', '00', '00'),
                'time' => '10:00:00',
                'description' => 'Venha celebrar a missa dominical conosco.',
                'location' => 'Igreja Matriz',
                'type_event_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'title' => 'Liturgia da Semana Santa',
                'subtitle' => 'Celebração da Semana Santa',
                'start_date' => Carbon::create('2024', '03', '24', '19', '00', '00'),
                'end_date' => null, // Data de término em branco
                'time' => '19:00:00',
                'description' => 'Participe da liturgia especial da Semana Santa.',
                'location' => 'Igreja Matriz',
                'type_event_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'title' => 'Festa de São João',
                'subtitle' => 'Celebração de São João Batista',
                'start_date' => Carbon::create('2024', '06', '24', '18', '00', '00'),
                'end_date' => Carbon::create('2024', '06', '24', '18', '00', '00'),
                'time' => '18:00:00',
                'description' => 'Uma festa cheia de tradições, comidas típicas e celebração da fé.',
                'location' => 'Igreja Matriz',
                'type_event_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'title' => 'Corpus Christi',
                'subtitle' => 'Celebração da Eucaristia',
                'start_date' => Carbon::create('2024', '05', '30', '16', '00', '00'),
                'end_date' => Carbon::create('2024', '05', '30', '16', '00', '00'),
                'time' => '16:00:00',
                'description' => 'Participe da celebração que renova nossa conexão espiritual.',
                'location' => 'Catedral Imaculada Conceição',
                'type_event_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'title' => 'Missas de Domingo',
                'subtitle' => 'Celebração dominical',
                'start_date' => Carbon::create('2024', '09', '29', '10', '00', '00'),
                'end_date' => Carbon::create('2024', '09', '29', '10', '00', '00'),
                'time' => '10:00:00',
                'description' => 'Venha celebrar a missa dominical conosco.',
                'location' => 'Igreja Matriz',
                'type_event_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'title' => 'Liturgia da Semana Santa',
                'subtitle' => 'Celebração da Semana Santa',
                'start_date' => Carbon::create('2024', '03', '24', '19', '00', '00'),
                'end_date' => Carbon::create('2024', '03', '31', '19', '00', '00'),
                'time' => '19:00:00',
                'description' => 'Participe da liturgia especial da Semana Santa.',
                'location' => 'Igreja Matriz',
                'type_event_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
