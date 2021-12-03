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
            $skills = [
                [
                    'name' => 'js',
                ],
                [
                    'name' => 'php',
                ],
                [
                    'name' => 'html',
                ],
                [
                    'name' => 'css',
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
