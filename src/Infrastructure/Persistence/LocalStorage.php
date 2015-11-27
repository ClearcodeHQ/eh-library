<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

/**
 * @todo create local storage
 * @todo it should have methods: save and get, no more
 */
final class LocalStorage
{
    /** @var LocalStorage */
    private static $instance;

    /** @var array */
    private $storage = [];

    /**
     * @return LocalStorage
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function add($key, $value)
    {
        $this->storage[$key] = $value;
    }

    /**
     * @param $key
     *
     * @throws \LogicException
     *
     * @return mixed
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            throw new \LogicException(sprintf('There is no object "%s"', $key));
        }

        return $this->storage[$key];
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function update($key, $value)
    {
        $this->add($key, $value);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->storage[$key]);
    }

    public function clear()
    {
        $this->storage = [];
    }

    private function __construct()
    {
    }
}
