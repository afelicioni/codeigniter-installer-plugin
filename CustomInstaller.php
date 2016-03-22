<?php
namespace AFelicioni;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class CustomInstaller extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'afelicioni-codeigniter' === $packageType;
    }
}