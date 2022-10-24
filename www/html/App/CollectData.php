<?php

namespace App;

use App\DB\QueryBuilder\QueryBuilderFactory;
use Exception;

class CollectData
{
    public static function process(): void
    {
        $user_ip        = self::get_client_ip();
        $user_agent     = $_SERVER['HTTP_USER_AGENT'];
        $current_url    = $_SERVER['REQUEST_URI'];

        if ($user_ip !== false) {
            try {
                $queryBuilder = QueryBuilderFactory::create('mysql');
                $data = $queryBuilder->getUserData($user_ip, $user_agent, $current_url);

                if (count($data)) {
                    $views_count    = $data[0]['views_count'] + 1;
                    $id             = $data[0]['id'];
                    $queryBuilder->updateUserData($id, $views_count);
                } else {
                    $queryBuilder->saveUserData($user_ip, $user_agent, $current_url);
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }
    }

    /**
     * Get users IP address
     * 
     * @return string|false
     */
    private static function get_client_ip()
    {
        $ipaddress = false;

        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];

        return $ipaddress;
    }
}
