<?php
namespace Wave\Base;


interface ILog
{
	/**
	 * @param string $message
	 * @param array ...$data
	 */
	public function info($message, ...$data);
	
	/**
	 * @param string $message
	 * @param array ...$data
	 */
	public function notice($message, ...$data);
	
	/**
	 * @param string $message
	 * @param array ...$data
	 */
	public function warning($message, ...$data);
	
	/**
	 * @param string $message
	 * @param array ...$data
	 */
	public function error($message, ...$data);
	
	/**
	 * @param string $message
	 * @param array ...$data
	 */
	public function crit($message, ...$data);
	
	/**
	 * @param \Exception $exception
	 * @param string|bool $message
	 * @param array ...$data
	 */
	public function exceptionInfo(\Exception $exception, $message = false, ...$data);
	
	/**
	 * @param \Exception $exception
	 * @param string|bool $message
	 * @param array ...$data
	 */
	public function exceptionNotice(\Exception $exception, $message = false, ...$data);
	
	/**
	 * @param \Exception $exception
	 * @param string|bool $message
	 * @param array ...$data
	 */
	public function exceptionWarning(\Exception $exception, $message = false, ...$data);
	
	/**
	 * @param \Exception $exception
	 * @param string|bool $message
	 * @param array ...$data
	 */
	public function exceptionError(\Exception $exception, $message = false, ...$data);
	
	/**
	 * @param \Exception $exception
	 * @param string|bool $message
	 * @param array ...$data
	 */
	public function exceptionCrit(\Exception $exception, $message = false, ...$data);
}