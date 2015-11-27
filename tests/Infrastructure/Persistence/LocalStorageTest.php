<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Infrastructure\Persistence\LocalStorage;

class LocalStorageTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalStorage */
    private $storage;

    /** @test */
    public function it_is_singleton()
    {
        $storage = LocalStorage::instance(true);

        $this->assertSame($this->storage, $storage);
    }

    /** @test */
    public function it_creates_database_file()
    {
        LocalStorage::instance(true);

        $this->assertTrue(file_exists('vfs://cache/database.db'));
    }

    /** @test */
    public function it_can_get_value()
    {
        $value = new \stdClass();

        $this->storage->save('value', $value);

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
        $this->storage->save('value', new \stdClass());

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
        $this->storage->save('value', 'val1');
        $this->storage->save('value', 'val2');

        $this->assertEquals('val2', $this->storage->get('value'));
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function it_can_be_cleared()
    {
        $this->storage->save('value', new \stdClass());
        $this->storage->clear();

        $this->storage->get('value');
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->storage = LocalStorage::instance(true);
        $this->storage->clear();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->storage = null;
    }
}
