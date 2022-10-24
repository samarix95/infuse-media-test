<?php

namespace App\DB\QueryBuilder;

abstract class QueryBuilderAbstract
{
    public function __construct()
    {
    }

    abstract public function getUserData(string $user_ip, string $user_agent, string $current_url): array;

    abstract public function saveUserData(string $user_ip, string $user_agent, string $current_url): void;

    abstract public function updateUserData(int $id, int $views_count): void;
}
