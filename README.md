utils-mongodb
============

[![Build Status](https://travis-ci.org/photon/utils-mongodb.svg?branch=master)](https://travis-ci.org/photon/utils-mongodb)

Various useful tools for MongoDB

PHP Versions
------------

- 5.6, 7.0 and 7.1 are supported and tested under travis
- Use ext-mongodb and mongodb/mongodb. Do not works anymore with legacy ext-mongo


Quick start
----------

1) Add the module in your project

    composer require "photon/utils-mongodb:dev-master"

or for a specific version

    composer require "photon/utils-mongodb:2.0.0"

2) Define a MongoDB connection in your project configuration

    'databases' => array(
        'default' => array(
            'engine' => '\photon\db\MongoDB',
            'server' => 'mongodb://localhost:27017/',
            'database' => 'utils',
            'options' => array(
                'connect' => true,
            ),
        ),
    ),

3) Enjoy !

Counters
--------

The counter class implement a atomic counter increment and retreive.
It's a thread safe auto-increment.

1) Create a class to define a counters collection

    class MyCounter extends \photon\utils\mongodb\Counter
    {
        const database = 'default';
        const collection = 'counters';
    }

2) Read / Write counter

        $value = MyCounter::get('foo');     // = 0
        $value = MyCounter::inc('foo');     // = 1
        $value = MyCounter::get('bar');     // = 0
        $value = MyCounter::get('foo');     // = 1

