<?php

namespace App\Http\Traits;

trait AirtableConsultantsTrait
{
    /**
     * @var \stdClass
     */
    private static $data;

    /**
     * @return \stdClass
     */
    public static function getData()
    {
        if (!self::$data) {
            $url = 'https://api.airtable.com/v0/appiqLowqq6wqVnb5/Imported%20Table?api_key=keyXsMhS5ZCyzilpy';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json = curl_exec($ch);
            self::$data = json_decode($json);
        }
        return self::$data;
    }

    /**
     * @param string $packageName
     * @return null|\stdClass
     */
    public static function getEntryByPackageName($packageName)
    {
        $data = self::getData();
        // dd($data);
        $records = [];
        foreach ($data->records as $record) {
            if ($record->fields->CRM == $packageName) {
                $records[] = $record->fields;
            }
        }
        if ($records) {
            return $records;
        }
        return null;
    }
}
