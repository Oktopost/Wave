<?php
namespace Wave\Source;


use Wave\Base\ILock;
use Wave\Base\ILockEntity;
use Wave\Base\Source\ISource;
use Wave\Base\Source\ISourceConnector;
use Wave\Base\Source\ISourceConnectorFactory;
use Wave\Enum\SourceType;
use Wave\Exceptions\WaveConfigException;
use Wave\Lock;
use Wave\Scope;


/**
 * @magic
 */
class Source implements ISource
{
	private $type = null;
	
	/** @var ILockEntity */
	private $lockEntity = null;
	
	
	/**
	 * @return string
	 */
	private function getType()
	{
		if (!$this->type)
		{
			$type = Scope::instance()->config('source.type', 'git');
			
			if (!SourceType::isExists($type))
			{
				throw new WaveConfigException(
					'source.type', 
					'Must be one of ' . implode(', ', SourceType::getAll()),
					$type);
			}
			
			$this->type = $type;
		}
		
		return $this->type;
	}
	
	
	/**
	 * @param ILock $lock
	 */
	public function __construct(ILock $lock) 
	{ 
		$this->lockEntity = $lock->source();
	}
	
	
	/**
	 * @return ISourceConnector
	 */
	public function connector()
	{
		/** @var ISourceConnectorFactory $factory */
		$factory = Scope::skeleton(ISourceConnectorFactory::class);
		return $factory->getConnector($this->getType());
	}
	
	public function lock()
	{
		$this->lockEntity->lock();
	}
	
	public function unlock()
	{
		$this->lockEntity->unlock();
	}
}