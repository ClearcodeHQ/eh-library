<?php

namespace tests\Clearcode\EHLibrary\Model;

use Clearcode\EHLibrary\Model\Object;

class ObjectTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_do_sth()
    {
        $object = new Object();

        $this->assertEquals('sth', $object->doSth());
    }
}
