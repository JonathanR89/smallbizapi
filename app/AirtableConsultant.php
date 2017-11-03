<?php

namespace App;


use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class AirtableConsultant extends Model
{
  use LogsActivity;

    public $primaryKey = "airtable_id";
    public $incrementing = false;
    protected $fillable = [
    "airtable_id",
    "record_name",
    "company",
    "short_description",
    "email",
    // "logo",
    "country",
    "state_province",
    "town",
    "pricing_pm",
    "industry_suitable_for",
    "speciality",
    "target_market",
    "url",
    "test_email",
    "description",
    "email_interested",
  ];
}
