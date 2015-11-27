<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

final class LocalStorage
{
    /** @var LocalStorage */
    private static $instance;
    /** @var string */
    private $path = 'cache/database.db';
    /** @var array */
    private $storage = [];

    /**
     * @param bool|false $testMode
     *
     * @return LocalStorage
     */
    public static function instance($testMode = false)
    {
        if (null === self::$instance) {
            self::$instance = new self($testMode);
        }

        return self::$instance;
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function save($key, $value)
    {
        $this->storage[$key] = $value;

        $this->write();
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
     * @param $pattern
     *
     * @return array
     */
    public function find($pattern)
    {
        $matching = [];

        foreach ($this->storage as $key => $object) {
            if (false !== strpos($key, $pattern)) {
                $matching[] = $object;
            }
        }

        return $matching;
    }

    public function clear()
    {
        $this->storage = [];

        $this->write();
    }

    private function __construct($testMode)
    {
        if ($testMode) {
            \org\bovigo\vfs\vfsStream::setup('cache');
            $this->path = 'vfs://'.$this->path;
        }

        $this->read();
    }

    private function read()
    {
        if (!file_exists($this->path)) {
            $this->write();
        }

        $contents = file_get_contents($this->path);

        $this->storage = unserialize($contents);
    }

    private function write()
    {
        $contents = serialize($this->storage);

        file_put_contents($this->path, $contents);
    }

    private function has($key)
    {
        return isset($this->storage[$key]);
    }
}
