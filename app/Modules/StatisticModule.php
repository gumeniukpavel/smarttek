<?php

namespace App\Modules;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class StatisticModule
{
    /**
     * @throws \Exception
     */
    public static function prepareStats(UploadedFile $uploadedFile): array
    {
        $response = [];
        $filepath = FileModule::saveFile($uploadedFile);
        $phoneModule = new PhoneModule();
        $countriesInfo = $phoneModule->getCountriesInfo();
        foreach (CSVParserModule::getLinesGenerator($filepath, 'data') as $line) {
            $info = [
                'customerId' => $line[0],
                'duration' => $line[2],
                'phoneNumber' => $line[3],
                'ip' => $line[4],
            ];

            if (!isset($response[$info['customerId']])) {
                $numbers = 0;
                $duration = 0;
                $totalNumbers = 0;
                $totalDuration = 0;
            } else {
                $data = $response[$info['customerId']];
                $numbers = $data['numbers'];
                $duration = $data['duration'];
                $totalNumbers = $data['totalNumbers'];
                $totalDuration = $data['totalDuration'];
            }

            $ipInfo = IPStackModule::checkIP($info['ip']);
            $ipContinentCode = $ipInfo['continent_code'] ?? 'EU';
            $phoneContinentCode = $phoneModule->getPhoneContinent($info['phoneNumber'], $countriesInfo);
            $totalNumbers += 1;
            $totalDuration += (int)$info['duration'];

            if ($ipContinentCode == $phoneContinentCode) {
                $numbers += 1;
                $duration += (int)$info['duration'];
            }

            $response[$info['customerId']] = [
                'numbers' => $numbers,
                'duration' => $duration,
                'totalNumbers' => $totalNumbers,
                'totalDuration' => $totalDuration
            ];
        }
        return $response;
    }
}