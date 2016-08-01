<?php
namespace Wave\Base\Target;


interface ICommandLine
{
	/**
	 * @param string $command
	 * @return string
	 */
	public function executeCommand($command);

	/**
	 * @param string $localFilePath
	 * @return string
	 */
	public function executeFile($localFilePath);
}