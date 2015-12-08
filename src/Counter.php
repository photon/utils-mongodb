<?php

namespace photon\utils\mongodb;
use photon\db\Connection;

abstract class Counter
{
    const database = 'default';
    const collection = 'counters';

    public static function get($id)
    {
        $db = Connection::get(static::database);
        $counters = $db->selectCollection(static::collection);
        $obj = $counters->findOne(array('_id' => $id));
        if ($obj === null) {
            return 0;
        }
        
        return $obj['c'];
    }    

    public static function inc($id)
    {
        $db = Connection::get(static::database);
        $obj = $db->command(array(
            'findandmodify' => static::collection,
            'query' => array('_id' => $id),
            'update' => array('$inc' => array('c' => 1)),
            'upsert' => 1,
            'new' => 1,
        ));
        
        return $obj['value']['c'];
    } 
}

