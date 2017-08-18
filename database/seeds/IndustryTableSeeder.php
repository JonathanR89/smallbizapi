<?php

use App\SubmissionIndustry;
use Illuminate\Database\Seeder;

class IndustryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $industries = collect([
        "Automotive Industry",
        "Beauty and Wellness Industry",
        "Childcare/Aftercare/Creche",
        "Construction and Architects",
        "Distributors",
        "Education",
        "Financial Services",
        "Franchises",
        "Freelancers",
        "Gambling/Casino",
        "Governments",
        "IT Dealers &amp; Service Providers",
        "Insurance Industry",
        "Legal Practices &amp; Attorneys",
        "Media &amp; Entertainment",
        "Medical &amp; Healthcare Profession",
        "Moving &amp; Storage",
        "Multi-Level Marketing (MLM)",
        "Newspapers &amp; Publishing",
        "NGO/NPO/Charities",
        "Pharmaceutical",
        "Real Estate",
        "Recruiting &amp; Staffing",
        "Restaurants",
        "Travel Agencies/Tourism",
      ]);
        $industries->each(function ($industry) {
            SubmissionIndustry::create([ "industry_name" => $industry]);
        });
    }
}
