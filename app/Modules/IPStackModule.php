<?php

namespace App\Modules;

class IPStackModule
{
    /**
     * @throws \Exception
     */
    public static function checkIP(string $ip)
    {
        $access_key = IPSTACK_KEY;

        $ch = curl_init('http://api.ipstack.com/' . $ip . '?access_key=' . $access_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            $result = json_decode($json, true);
            if (isset($result['success']) && $result['success'] == false){
                throw new \Exception($result['error']['info']);
            }
            return $result;
        } else {
            throw new \Exception("IPStack Error");
        }
    }
}