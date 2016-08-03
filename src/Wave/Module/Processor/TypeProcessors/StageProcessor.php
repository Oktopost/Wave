<?php
namespace Wave\Module\Processor\TypeProcessors;


use Wave\Enum\CommandType;
use Wave\Base\Module\IStage;

use Wave\Scope;
use Wave\Objects\Package;
use Wave\Commands\Types\StageCommand;


/**
 * @magic
 */
class StageProcessor extends BaseProcessor
{
	/** @var IStage */
	private $stage;
	
	
	/**
	 * @param Package $package
	 * @param string $serverName
	 */
	private function stageToServer(Package $package, $serverName)
	{
		$server = $this->getServer($serverName);
		
		Scope::instance()->log()->info(
			'Staging @0 on Server @1/@2',
			$package->Name, $server->Name, $server->IP);
		
		$this->stage
			->setPackage($package)
			->setServer($server)
			->stage();
		
		Scope::instance()->log()->info(
			'Version @0 staged to Server @1/@2',
			$package->Name, $server->Name, $server->IP);
	}
	
	/**
	 * @param IStage $stage
	 */
	public function __construct(IStage $stage)
	{
		$this->stage = $stage;
	}
	
	
	/**
	 * @return string
	 */
	public function getType()
	{
		return CommandType::STAGE;
	}
	
	public function execute()
	{
		/** @var StageCommand $command */
		$command = $this->command();
		
		$package = Package::create($command->Version, $command->BuildTarget);
		
		foreach ($command->Servers as $serverName)
		{
			$this->stageToServer($package, $serverName);
		}
	}
}