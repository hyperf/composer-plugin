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
namespace Hyperf\Composer\Plugin\Event;

use Composer\Composer;
use Composer\IO\IOInterface;

interface HandlerInterface
{
    public function __construct(Composer $composer, IOInterface $io);

    public function listen(): array;

    public function execute(): void;
}
