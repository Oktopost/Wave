<?php
namespace Wave\Exceptions;


class WaveConfigException extends WaveException
{
	/**
	 * @param string $configName
	 * @param string $message
	 * @param string $unexpectedValue
	 */
	public function __construct($configName, $message, $unexpectedValue = 'undefined')
	{
		parent::__construct("Invalid config value encountered: $configName = $unexpectedValue. $message", 4);
	}
}