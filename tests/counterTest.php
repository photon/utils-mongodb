<?php

use photon\db\Connection;

class MyCounters extends \photon\utils\mongodb\Counter
{
    const database = 'default';
    const collection = 'counters';
}

class MyCountersTest extends \photon\test\TestCase
{
    public function testCounter()
    {
        MyCounters::resetAll();

        $value = MyCounters::get('foo');
        $this->assertEquals($value, 0);

        $value = MyCounters::inc('foo');
        $this->assertEquals($value, 1);

        $value = MyCounters::get('bar');
        $this->assertEquals($value, 0);

        $value = MyCounters::get('foo');
        $this->assertEquals($value, 1);

        MyCounters::reset('foo');
        $value = MyCounters::get('foo');
        $this->assertEquals($value, 0);
    }
}
