<?php
namespace Wave\Base\Build\Phing;


use Wave\Exceptions\Phing\PhingException;


/**
 * @skeleton
 */
interface IPhingBuilder
{
	/**
	 * @param PhingConfig $config
	 * @return static
	 */
	public function setConfig(PhingConfig $config);
	
	/**
	 * @throws PhingException
	 */
	public function build();
}