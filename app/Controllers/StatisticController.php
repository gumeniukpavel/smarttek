<?php

namespace App\Controllers;

use App\Modules\BladeModule;
use App\Modules\CSVParserModule;
use App\Modules\FileModule;
use App\Modules\IPStackModule;
use App\Modules\PhoneModule;
use App\Modules\StatisticModule;
use Symfony\Component\HttpFoundation\Request;

class StatisticController
{
    public function prepareStatsAction(Request $request): string
    {
        try {
            $uploadedFile = $request->files->get('csv');
            if ($uploadedFile) {
                $response = StatisticModule::prepareStats($uploadedFile);
                return BladeModule::render('stats', ['response' => $response]);
            } else {
                return BladeModule::render('stats', ['error' => 'Select file!']);
            }
        } catch (\Exception $ex) {
            return BladeModule::render('stats', ['error' => $ex->getMessage()]);
        }
    }
}