<?php
namespace Wave\Base\FileSystem;


use Wave\Exceptions\FileException;

use Objection\LiteObject;


/**
 * @skeleton
 */
interface IJsonFile
{
	/**
	 * @param string $file
	 * @throws FileException
	 */
	public function setTarget($file);
	
	/**
	 * @param string $className LiteObject class name.
	 * @return LiteObject
	 * @throws FileException
	 */
	public function loadFile($className);
	
	/**
	 * @param string $className LiteObject class name.
	 * @return LiteObject[]
	 * @throws FileException
	 */
	public function loadAll($className);
	
	/**
	 * @param LiteObject $fileObject
	 * @throws FileException
	 */
	public function save(LiteObject $fileObject);
	
	/**
	 * @param LiteObject[] $fileObjects
	 * @throws FileException
	 */
	public function saveAll(array $fileObjects);
}