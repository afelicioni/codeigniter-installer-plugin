<?php
namespace AFelicioni;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;

class CustomInstaller extends LibraryInstaller
{
	/**
	 * {@inheritDoc}
	 */
	public function supports($packageType)
	{
		return 'afelicioni-codeigniter' === $packageType;
	}

	/**
	 * {@inheritDoc}
	 */
	public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
	{
		parent::install($repo, $package);
		$this->applyExtra($package);
	}

	public function applyExtra(PackageInterface $package)
	{
		$extra = $package->getExtra();
		if (!isset($extra['target-path']) || !isset($extra['setup-files'])) {
			throw new \RuntimeException('Keys `target-path` and `setup-files` in extra are mandatory.');
		}

		$sourcePath = $this->getInstallPath($package);
		$targetPath = $extra['target-path'];

		$this->io->write('Using source as `' . $sourcePath . '`');
		$this->io->write('Using target as `' . $targetPath . '`');

		foreach ($extra['setup-files'] as $fn) {
			$source = $sourcePath . DIRECTORY_SEPARATOR . $fn[0];
			$target = $targetPath . DIRECTORY_SEPARATOR . $fn[1];
			if (!is_dir(dirname($target))) {
				mkdir(dirname($target), 0755, true);
			}
			$this->io->write('Copying `' . $target . '`');
			copy($source, $target);
		}
	}
}