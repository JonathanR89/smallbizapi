<?php

use App\SubmissionPriceRange;
use Illuminate\Database\Seeder;

class SubmissionPriceRangeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         $priceRanges = collect([
           "Free",
           "$1-$25",
           "$26-$50",
           "$51-$100",
           "$101-$200",
           "$201+",
     ]);
         $priceRanges->each(function ($priceRange) {
             SubmissionPriceRange::create(["price_range" => $priceRange]);
         });
     }
}
