<?php

namespace App\Http\Traits;

use \TANIOS\Airtable\Airtable;

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
        $airtable = new Airtable(array(
        'api_key'=> 'keyXsMhS5ZCyzilpy',
        'base'   => 'appiqLowqq6wqVnb5'
      ));
        $data = [];
        $request = $airtable->getContent('Consultants');
        do {
            $response = $request->getResponse();
            $data[] = $response[ 'records' ];
        } while ($request = $response->next());
        return $data;
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
