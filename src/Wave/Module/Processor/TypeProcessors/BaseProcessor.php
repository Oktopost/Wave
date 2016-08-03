<?php
namespace Wave\Module\Processor\TypeProcessors;


use Wave\Base\Module\Processor\ITypeProcessor;
use Wave\Base\Commands\Command;
use Wave\Base\StorageLayer\IData;
use Wave\Exceptions\WaveException;

use Wave\Scope;
use Wave\Objects\Server;


abstract class BaseProcessor implements ITypeProcessor
{
	/** @var Command */
	private $command;
	
	
	/**
	 * @return Command
	 */
	protected function command()
	{
		return $this->command;
	}
	
	/**
	 * @param string $serverName
	 * @return Server
	 */
	protected function getServer($serverName)
	{
		/** @var IData $data */
		$data = Scope::skeleton(IData::class);
		$servers = $data->servers()->load();
		
		foreach ($servers as $server)
		{
			if ($server->Name == $serverName)
				return $server;
		}
		
		throw new WaveException("Server with name '$serverName' was not found");
	}
	
	
	/**
	 * @return string
	 */
	public abstract function getType();
	
	public abstract function execute();
	
	
	/**
	 * @param Command $command
	 * @return static
	 */
	public function setCommand(Command $command)
	{
		$this->command = $command;
		return $this;
	}
}