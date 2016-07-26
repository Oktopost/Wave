<?php
namespace Wave\Exceptions\Phing;


use Wave\Exceptions\WaveException;


class PhingException extends WaveException
{
	public function __construct($message, $code = 0, \Exception $previous = null)
	{
		parent::__construct("Phing build failed: $message", $code, $previous);
	}
}