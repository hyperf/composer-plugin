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

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;
use Hyperf\Composer\Plugin\Event\HandlerInterface;
use Hyperf\Composer\Plugin\Event\SortFilesHandler;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    public function __call(string $name, array $arguments = [])
    {
        $handler = new $name();
        if ($handler instanceof HandlerInterface) {
            $handler->execute($this->composer, $this->io);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_ROOT_PACKAGE_INSTALL => [
                SortFilesHandler::class,
            ],
        ];
    }

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }
}
