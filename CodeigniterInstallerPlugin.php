<?php
namespace AFelicioni;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class CodeigniterInstallerPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new CustomInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}