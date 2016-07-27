<?php
namespace Wave\Source;


use Wave\Enum\SourceType;
use Wave\Base\Source\ISourceConnector;
use Wave\Base\Source\ISourceConnectorFactory;

use Wave\Scope;
use Wave\Source\Git\GitSource;
use Wave\Exceptions\WaveException;

use Skeleton\ISingleton;


class SourceConnectorFactory implements ISourceConnectorFactory, ISingleton
{
	/**
	 * @param string $type
	 * @return ISourceConnector
	 */
	public function getConnector($type)
	{
		switch ($type)
		{
			case SourceType::GIT:
				$sourceClass = GitSource::class;
				break;
			
			case SourceType::SVN:
				throw new WaveException("Unsupported source type '$type'");
				
			default:
				throw new WaveException("Unexpected source type! Got '$type'");
		}
		
		return Scope::skeleton()->load($sourceClass);
	}
}