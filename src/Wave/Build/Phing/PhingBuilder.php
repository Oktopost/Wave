<?php
namespace Wave\Build\Phing;


use Wave\Scope;
use Wave\Base\Build\Phing\PhingConfig;
use Wave\Base\Build\Phing\IPhingBuilder;

use Wave\Exceptions\WaveUnexpectedException;
use Wave\Exceptions\Phing\PhingException;


class PhingBuilder implements IPhingBuilder
{
	/** @var PhingConfig */
	private $config;
	
	/**
	 * @return string
	 */	
	private function createPhingCommand()
	{
		$arguments = [
			$this->config->PathToPhing,
			$this->config->TargetBuild,
			
			'-logfile',		$this->config->LogFile,
			'-buildfile ',	$this->config->TargetBuildFile,
			'-logger',		'phing.listener.DefaultLogger'			
		];
		
		return implode(' ', $arguments);
	}
	
	
	/**
	 * @param PhingConfig $config
	 * @return static
	 */
	public function setConfig(PhingConfig $config)
	{
		$this->config = $config;
		return $this;
	}
	
	/**
	 * @throws PhingException
	 */
	public function build()
	{
		if (is_null($this->config))
			throw new WaveUnexpectedException('Config not set');
		
		$command = "cd {$this->config->SourceDirectory} && {$this->createPhingCommand()}";
		
		Scope::instance()->log()->info("Executing: $command");
		exec($command, $result, $returnCode);
		Scope::instance()->log()->info("Phing complete with code: $returnCode");
		
		if ($returnCode != 0)
			throw new PhingException('Phing build failed');
	}
}