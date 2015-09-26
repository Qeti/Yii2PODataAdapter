<?php

namespace qeti\SimplePOData;

use yii\db\Connection;

class QueryProvider extends BaseQueryProvider
{
    public function __construct(Connection $db){
        parent::__construct($db);
    }

    protected function queryAll($sql, $parameters = null)
    {
    	return $this->db->createCommand($sql, $parameters)->queryAll();
    }

    protected function queryScalar($sql, $parameters = null)
    {
    	return $this->db->createCommand($sql, $parameters)->queryScalar();
    }

}