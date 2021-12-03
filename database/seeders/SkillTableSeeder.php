<?php

namespace Database\Seeders;

use App\Models\Skill;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $now = now();

            $skills = [
                [
                    'name' => 'js',
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
                [
                    'name' => 'php',
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
                [
                    'name' => 'html',
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
                [
                    'name' => 'css',
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
            ];

            Skill::insert($skills);

            DB::commit();
        }catch (Exception $exception){
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
