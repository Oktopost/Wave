<?php
namespace Wave\Module\Processor\TypeProcessors;


use Wave\Enum\CommandType;
use Wave\Base\Module\IBuild;

use Wave\Scope;
use Wave\Objects\Package;
use Wave\Commands\Types\BuildCommand;


/**
 * @magic
 */
class BuildProcessor extends BaseProcessor
{
	/** @var IBuild */
	private $build;
	
	
	/**
	 * @param IBuild $build
	 */
	public function __construct(IBuild $build) 
	{ 
		$this->build = $build;
	}
	
	
	/**
	 * @return string
	 */
	public function getType()
	{
		return CommandType::BUILD;
	}
	
	public function execute()
	{
		/** @var BuildCommand $command */
		$command = $this->command();
		$package = Package::create($command->Version, $command->BuildTarget);
		
		Scope::instance()->log()->info('Building package @0', $package->Name);
		
		$this->build
			->setTargetPackage($package)
			->build();
		
		Scope::instance()->log()->info('Build of package @0 complete', $package->Name);
	}
}