<?php

namespace App\Modules;

class PhoneModule
{
    public function getCountriesInfo(): array
    {
        $txtFile = file_get_contents('http://download.geonames.org/export/dump/countryInfo.txt');
        $rows = explode("\n", $txtFile);
        array_shift($rows);

        $phoneCodeIndex = 0;
        $continentIndex = 0;
        $result = [];
        foreach ($rows as $row => $data) {
            if ($row < 48) {
                continue;
            }

            if ($row == 48) {
                $fields = explode("\t", $data);
                foreach ($fields as $index => $field) {
                    if ($field == 'Continent') {
                        $continentIndex = $index;
                    }
                    if ($field == 'Phone') {
                        $phoneCodeIndex = $index;
                    }
                }
                continue;
            }
            $data = explode("\t", $data);
            $result[] = array(
                'phoneCode' => $data[$phoneCodeIndex] ?? 0,
                'continent' => $data[$continentIndex] ?? 0
            );
        }
        return $result;
    }

    public function getPhoneContinent(string $phone, $infos)
    {
        foreach ($infos as $info) {
            $phoneCode = preg_replace('/\D/', '', $info['phoneCode']);
            if (str_starts_with($phone, $phoneCode) && $phoneCode != '') {
                return $info['continent'];
            }
        }
        return 'NAN';
    }
}