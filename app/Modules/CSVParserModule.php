<?php

namespace App\Modules;

class CSVParserModule
{
    public static function getLinesGenerator($file, $folder): \Generator
    {
        $row = 1;
        if (($handle = fopen("$folder/$file", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                yield $data;
            }
            fclose($handle);
        }
    }
}