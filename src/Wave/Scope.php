<?php
namespace Wave;


use Wave\Base\ILog;

use Skeleton\Type;
use Skeleton\Skeleton;
use Skeleton\UnitTestSkeleton;
use Skeleton\ConfigLoader\PrefixDirectoryConfigLoader;


class Scope
{
	use \Objection\TSingleton;
	
	
	/** @var Skeleton */
	private $skeleton;
	
	/** @var UnitTestSkeleton */
	private $testSkeleton;
	
	/** @var ILog */
	private $log = null;
	
	/** @var Config */
	private $config = null;
	
	
	/**
	 * @param static $instance
	 */
	protected static function initialize($instance)
	{
		$skeleton = new Skeleton();
		$skeleton
			->enableKnot()
			->setConfigLoader(
				new PrefixDirectoryConfigLoader([
					'Wave' => __DIR__ . '/../../skeleton'
				])
			);
		
		$instance->skeleton = $skeleton;
	}
	
	
	/**
	 * @return ILog
	 */
	public function log()
	{
		if (!$this->log)
			$this->log = $this->skeleton(ILog::class);
		
		return $this->log;
	}
	
	/**
	 * @param bool $key
	 * @param mixed $default
	 * @return mixed|string|Config
	 */
	public function config($key = false, $default = null)
	{
		if (is_null($this->config))
			$this->config = new Config('wave.ini');
		
		return $key ?
			$this->config->get($key, $default) : 
			$this->config;
	}
	
	/**
	 * For unit tests only.
	 * @todo <alexey> 2016-07-26 Remove unit tests only method.
	 * @param Config $config
	 */
	public function setConfig(Config $config)
	{
		$this->config = $config;
	}
	
	
	/**
	 * @return string
	 */
	public static function rootDir()
	{
		return getcwd();
	}
	
	/**
	 * @param string|bool $interface
	 * @param string|null $implementer
	 * @return object|UnitTestSkeleton
	 */
	public static function testSkeleton($interface = false, $implementer = null)
	{
		if (!self::instance()->testSkeleton)
		{
			self::instance()->testSkeleton = new UnitTestSkeleton(self::instance()->skeleton);
		}
		
		if (!$interface)
		{
			return self::instance()->testSkeleton;
		}
		else if ($implementer)
		{
			return self::instance()->testSkeleton->override($interface, $implementer);
		}
		else
		{
			return self::instance()->testSkeleton->get($interface);
		}
	}
	
	/**
	 * @param string|bool $interface
	 * @param string|null $implementer
	 * @param int $type
	 * @return object|\Skeleton\Skeleton
	 */
	public static function skeleton($interface = false, $implementer = null, $type = Type::Instance)
	{
		if (!$interface)
		{
			return self::instance()->skeleton;
		}
		else if ($implementer)
		{
			return self::instance()->skeleton->set($interface, $implementer, $type);
		}
		else
		{
			return self::instance()->skeleton->get($interface);
		}
	}
}