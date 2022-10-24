<?php

namespace App\DB\QueryBuilder;

use Exception;

class QueryBuilderFactory
{
    public static function create(string $db_type): QueryBuilderAbstract
    {
        switch ($db_type) {
            case "mysql":
                return new QueryBuilderMySQL();
                break;
            default:
                throw new Exception("DB type $db_type not found");
                break;
        }
    }
}
