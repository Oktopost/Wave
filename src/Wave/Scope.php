<?php
namespace Wave;


use Skeleton\Type;
use Skeleton\Skeleton;
use Skeleton\ConfigLoader\PrefixDirectoryConfigLoader;


class Scope
{
	use \Objection\TSingleton;
	
	
	/** @var Skeleton */
	private $skeleton;
	
	
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
					'Wave' => realpath(__DIR__ . '/../../skeleton')
				])
			);
		
		$instance->skeleton = $skeleton;
	}
	
	
	/**
	 * @param string|bool $interface
	 * @param string|null $implementer
	 * @param int $type
	 * @return object|\Skeleton\Skeleton
	 */
	public function skeleton($interface = false, $implementer = null, $type = Type::Instance)
	{
		if (!$interface)
		{
			return $this->skeleton;
		}
		else if ($implementer)
		{
			return $this->skeleton->set($interface, $implementer, $type);
		}
		else
		{
			return $this->skeleton->get($interface);
		}
	}
}