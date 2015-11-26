<?php

namespace tests\Clearcode\EHLibrary\Infrastructure;

use Clearcode\EHLibrary\Infrastructure\InMemoryStorage;

class InMemoryStorageTest extends \PHPUnit_Framework_TestCase
{
    /** @var InMemoryStorage */
    private $storage;

    /** @test */
    public function it_is_singleton()
    {
        $storage = InMemoryStorage::instance();

        $this->assertSame($this->storage, $storage);
    }

    /** @test */
    public function it_can_get_value()
    {
        $value = new \stdClass();

        $this->storage->add('value', $value);

        $this->assertSame($value, $this->storage->get('value'));
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function it_fails_when_value_with_given_key_does_not_exists()
    {
        $this->storage->get('value');
    }

    /** @test */
    public function it_has_value()
    {
        $this->storage->add('value', new \stdClass());

        $this->assertTrue($this->storage->has('value'));
    }

    /** @test */
    public function it_has_not_value()
    {
        $this->assertFalse($this->storage->has('value'));
    }

    /** @test */
    public function it_can_update_value()
    {
        $this->storage->add('value', 'val1');
        $this->storage->update('value', 'val2');

        $this->assertEquals('val2', $this->storage->get('value'));
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function it_can_be_cleared()
    {
        $this->storage->add('value', new \stdClass());
        $this->storage->clear();

        $this->storage->get('value');
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->storage = InMemoryStorage::instance();
        $this->storage->clear();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->storage = null;
    }
}
