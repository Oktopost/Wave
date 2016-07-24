<?php
namespace Wave\Source;


use Wave\Enum\SourceType;
use Wave\Base\Source\ISourceManager;
use Wave\Base\Source\ISourceManagerFactory;

use Wave\Scope;
use Wave\Source\Git\GitSource;
use Wave\Exceptions\WaveException;

use Skeleton\ISingleton;


class SourceManagerFactory implements ISourceManagerFactory, ISingleton
{
	/**
	 * @param string $type
	 * @return ISourceManager
	 */
	public function get($type)
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
		
		return Scope::instance()->skeleton()->load($sourceClass);
	}
}