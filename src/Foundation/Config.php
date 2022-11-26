<?php

namespace Larso\Foundation;

use Illuminate\Support\Arr;

class Config implements \ArrayAccess
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;

        $this->requireKeys('url');
    }

    private function requireKeys(...$keys)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $this->data)) {
                throw new \InvalidArgumentException(
                    "Configuration is invalid without a $key key"
                );
            }
        }
    }

    public function inDebugMode(): bool
    {
        return $this->data['debug'] ?? false;
    }

    public function url()
    {
        return rtrim($this->data['url'], '/');
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return Arr::get($this->data, $offset);
    }

    public function offsetExists($offset): bool
    {
        return Arr::has($this->data, $offset);
    }

    public function offsetSet($offset, $value): void
    {
        throw new RuntimeException('The Config is immutable');
    }

    public function offsetUnset($offset): void
    {
        throw new RuntimeException('The Config is immutable');
    }
}
