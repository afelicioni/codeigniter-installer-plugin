<?php
namespace AFelicioni;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;

class CustomInstaller extends LibraryInstaller
{
	/*protected $composer;
	protected $package;
	protected $io;*/
	protected $locations = array(
		'config'		=> 'application/config/',
		'libraries'		=> 'application/libraries/',
		'controllers'	=> 'application/controllers/',
	);

	/*public function __construct(PackageInterface $package = null, Composer $composer = null, IOInterface $io = null)
	{
		$this->composer = $composer;
		$this->package = $package;
		$this->io = $io;
	}*/

	/**
	 * {@inheritDoc}
	 */
	/*public function getInstallPath(PackageInterface $package, $frameworkType = '')
	{
		$prettyName = $package->getPrettyName();
		$type = $package->getType();
		//$customPath = $this->mapPaths($this->locations, $prettyName);
		//if ($customPath !== false) {
		//    return $customPath;
		//}
		return 'vendor/afelicioni__'.$frameworkType;
	}*/

	/**
	 * {@inheritDoc}
	 */
	public function supports($packageType)
	{
		return 'afelicioni-codeigniter' === $packageType;
	}

	/*private function mapPaths($paths, $name)
	{
		foreach ($paths as $path => $names) {
			if (in_array($name, $names) || in_array('type:' . $type, $names)) {
				return $path;
			}
		}
		return false;
	}*/
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