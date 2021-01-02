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
use Composer\Config;
use Composer\Installer\InstallationManager;
use Composer\IO\IOInterface;
use Composer\Package\RootPackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use Hyperf\Composer\Plugin\AutoloadGenerator;

class SortFilesHandler implements HandlerInterface
{
    public function execute(Composer $composer, IOInterface $io): void
    {
        $sortWeight = $composer->getPackage()->getExtra()['hyperf']['plugin']['sort-autoload'] ?? [];

        $mainGenerator = $composer->getAutoloadGenerator();
        $generator = new AutoloadGenerator($composer->getEventDispatcher(), $io);
        $ref = new \ReflectionClass($mainGenerator);
        foreach ($ref->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($mainGenerator);
            $setter = 'set' . ucfirst($property->getName());
            if (! is_object($value) && method_exists($generator, $setter)) {
                $generator->{$setter}($value);
            }
        }

        $composer->setAutoloadGenerator($generator->setSortWeight($sortWeight));

        // Config $config, InstalledRepositoryInterface $localRepo, RootPackageInterface $rootPackage, InstallationManager $installationManager, $targetDir, $scanPsrPackages = false, $suffix = ''
        // $generator->setSortWeight($sortWeight)->dump(
        //     $composer->getConfig(),
        //     $composer->getRepositoryManager()->getLocalRepository(),
        //     $composer->getPackage(),
        //     $composer->getInstallationManager(),
        //     'composer',
        //     true
        // );
    }
}
