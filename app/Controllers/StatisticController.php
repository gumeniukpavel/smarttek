<?php

namespace App\Controllers;

use App\Modules\Blade;
use App\Modules\CSVParser;
use App\Modules\File;
use App\Modules\IPStack;
use App\Modules\Phone;
use Symfony\Component\HttpFoundation\Request;

class StatisticController
{
    public function prepareStatsAction(Request $request)
    {
        try {
            $uploadedFile = $request->files->get('csv');
            $response = [];
            if ($uploadedFile) {
                $filepath = File::saveFile($uploadedFile);
                $phoneModule = new Phone();
                $countriesInfo = $phoneModule->getCountriesInfoGenerator();
                foreach (CSVParser::getLinesGenerator($filepath, 'data') as $line) {
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

//                    $ipInfo = IPStack::checkIP($info['ip']);
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
                return Blade::render('stats', ['response' => $response]);
            } else {
                return Blade::render('stats', ['error' => 'Select file!']);
            }
        } catch (\Exception $ex) {
            return Blade::render('stats', ['error' => $ex->getMessage()]);
        }
    }
}