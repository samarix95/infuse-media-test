<?php

namespace App\DB\QueryBuilder;

use App\DB\Connection\MySQL;
use Exception;

class QueryBuilderMySQL extends QueryBuilderAbstract
{
    /**
     * @var MySQL
     */
    private $db = null;

    public function __construct()
    {
        try {
            $this->db = MySQL::getInstance();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getUserData(string $user_ip, string $user_agent, string $current_url): array
    {
        $result     = [];
        $userData   = $this->prepareUserData($user_ip, $user_agent, $current_url);
        $sql        = "SELECT * FROM `user_data` WHERE ip_address = '" . $userData['user_ip'] . "' and user_agent = '" . $userData['user_agent'] . "' and page_url = '" . $userData['current_url'] . "'";

        try {
            $result = $this->db->select($sql);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    public function saveUserData(string $user_ip, string $user_agent, string $current_url): void
    {
        $view_date  = date('Y-m-d h:i:s');
        $userData   = $this->prepareUserData($user_ip, $user_agent, $current_url);
        $sql        = "INSERT INTO `user_data` (ip_address, user_agent, view_date, page_url, views_count) VALUES (:ip_address, :user_agent, :view_date, :page_url, :views_count)";
        $data = [
            'ip_address'    => $userData['user_ip'],
            'user_agent'    => $userData['user_agent'],
            'view_date'     => $view_date,
            'page_url'      => $userData['current_url'],
            'views_count'   => 1,
        ];

        try {
            $this->db->insertOrUpdate($sql, $data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateUserData(int $id, int $views_count): void
    {
        $view_date  = date('Y-m-d h:i:s');
        $sql        = "UPDATE `user_data` SET views_count = :views_count, view_date = :view_date WHERE id = :id";
        $data = [
            'id'            => $id,
            'view_date'     => $view_date,
            'views_count'   => $views_count,
        ];

        try {
            $this->db->insertOrUpdate($sql, $data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function prepareUserData(string $user_ip, string $user_agent, string $current_url): array
    {
        $user_ip        = str_replace("'", "\'", $user_ip);
        $user_agent     = str_replace("'", "\'", $user_agent);
        $current_url    = str_replace("'", "\'", $current_url);

        return [
            'user_ip'       => $user_ip,
            'user_agent'    => $user_agent,
            'current_url'   => $current_url,
        ];
    }
}
