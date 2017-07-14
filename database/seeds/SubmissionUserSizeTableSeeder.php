<?php

use App\SubmissionUserSize;
use Illuminate\Database\Seeder;

class SubmissionUserSizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userSizes = collect([
        "1 - 5 People",
        "6 - 20 People",
        "21 - 50 People",
        "51 - 100 People",
        "101 - 200 People",
        "200 + People",
    ]);
        $userSizes->each(function ($userSize) {
            SubmissionUserSize::create(["user_size" => $userSize]);
        });
    }
}
