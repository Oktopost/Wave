<?php
namespace Wave\Module\Processor\TypeProcessors;


use Wave\Enum\CommandType;
use Wave\Base\Module\IDeployment;

use Wave\Scope;
use Wave\Objects\Package;
use Wave\Commands\Types\DeployCommand;


/**
 * @magic
 */
class DeployProcessor extends BaseProcessor
{
	/** @var IDeployment */
	private $deploy;
	
	
	/**
	 * @param Package $package
	 * @param string $serverName
	 */
	private function deployToServer(Package $package, $serverName)
	{
		$server = $this->getServer($serverName);
		
		Scope::instance()->log()->info(
			'Deploying @0 to Server @1/@2',
			$package->Name, $server->Name, $server->IP);
		
		$this->deploy
			->setPackage($package)
			->setServer($server)
			->deploy();
		
		Scope::instance()->log()->info(
			'Version @0 deployed to Server @1/@2',
			$package->Name, $server->Name, $server->IP);
	}
	
	
	/**
	 * @param IDeployment $deploy
	 */
	public function __construct(IDeployment $deploy)
	{
		$this->deploy = $deploy;
	}
	
	
	/**
	 * @return string
	 */
	public function getType()
	{
		return CommandType::DEPLOY;
	}
	
	public function execute()
	{
		/** @var DeployCommand $command */
		$command = $this->command();
		
		$package = Package::create($command->Version, $command->BuildTarget);
		
		foreach ($command->Servers as $serverName)
		{
			$this->deployToServer($package, $serverName);
		}
	}
}