<?php
namespace Wave;


class Config
{
	/** @var array */
	private $config;
	
	
	/**
	 * @param string $file
	 */
	public function __construct($file) 
	{
		$this->config = parse_ini_file($file);
	}
	
	
	/**
	 * @return array
	 */
	public function getAll()
	{
		return $this->config;
	}
	
	
	/**
	 * @param string $key
	 * @param mixed|null $default
	 * @return string|mixed
	 */
	public function get($key, $default = null)
	{
		return isset($this->config[$key]) ? $this->config[$key] : $default; 
	}
}