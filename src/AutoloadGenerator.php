<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Hyperf\Composer\Plugin;

use Composer\Autoload\AutoloadGenerator as Generator;

class AutoloadGenerator extends Generator
{
    protected $sortWeight = [];

    public function setSortWeight(array $sortWeight)
    {
        $this->sortWeight = $sortWeight;
        return $this;
    }

    protected function getSortWeight(string $name): int
    {
        foreach ($this->sortWeight as $k => $priority) {
            if (strpos($name, $k) !== false) {
                return (int) $priority;
            }
        }

        return 0;
    }

    protected function sortPackageMap(array $packageMap)
    {
        $map = parent::sortPackageMap($packageMap);
        $queue = new \SplPriorityQueue();
        foreach ($map as $k => $item) {
            [, $path] = $item;
            $queue->insert($item, [$this->getSortWeight($path), PHP_INT_MAX - $k]);
        }

        $result = [];
        foreach ($queue as $item) {
            [, $path] = $item;
            $result[] = $item;
        }

        return $result;
    }
}
