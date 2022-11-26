<?php

namespace Larso\Foundation;

use InvalidArgumentException;

class Paths
{
    private $paths;

    public function __construct(array $paths)
    {
        if (! isset($paths['base'], $paths['storage'])) {
            throw new InvalidArgumentException(
                'Paths array requires keys base and storage'
            );
        }

        $this->paths = array_map(function ($path) {
            return rtrim($path, '\/');
        }, $paths);

        // Assume a standard Composer directory structure unless specified
        $this->paths['vendor'] = $this->vendor ?? $this->base.'/vendor';
    }

    public function __get($name): ?string
    {
        return $this->paths[$name] ?? null;
    }
}
