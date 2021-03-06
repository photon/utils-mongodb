<?php

namespace photon\utils\mongodb;
use photon\db\Connection;

abstract class Counter
{
    const database = 'default';
    const collection = 'counters';

    public static function resetAll()
    {
        $db = Connection::get(static::database);
        $counters = $db->{static::collection};
        $counters->drop();
    }

    public static function reset($id)
    {
        $db = Connection::get(static::database);
        $counters = $db->{static::collection};
        $counters->deleteOne(array('_id' => $id));
    }

    public static function get($id)
    {
        $db = Connection::get(static::database);
        $counters = $db->{static::collection};

        $obj = $counters->findOne(array('_id' => $id));
        if ($obj === null) {
            return 0;
        }
        
        return $obj['c'];
    }    

    public static function inc($id)
    {
        $db = Connection::get(static::database);

        // PHP 7.0+  (mongodb)
        if (version_compare(PHP_VERSION, '7.0.0', '>=')) {
            $counters = $db->{static::collection};

            $obj = $counters->findOneAndUpdate(
                    array('_id' => $id),
                    array('$inc' => array('c' => 1)),
                    array(
                        'upsert' => true,
                        'returnDocument' => \MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER
                    )
            );

            return $obj['c'];
        }

        // PHP 5.6 (mongo)
        $obj = $db->command(array(
            'findandmodify' => static::collection,
            'query' => array('_id' => $id),
            'update' => array('$inc' => array('c' => 1)),
            'upsert' => 1,
            'new' => 1,
        ));

        $objs = $obj->toArray();
        $obj = $objs[0];

        return $obj['value']['c'];
    } 
}

