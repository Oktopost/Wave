<?php
namespace Wave\FileSystem;


use Wave\Base\FileSystem\IJsonFile;
use Wave\Exceptions\FileException;

use Objection\LiteObject;


class JsonFile implements IJsonFile
{
	private $file;
	
	
	/**
	 * @throws FileException
	 */
	private function validateFile()
	{
		if (!is_readable($this->file) || !is_writable($this->file))
			throw new FileException($this->file, 'File must be both readable and writable by the user running Wave');
		
		if (substr($this->file, strlen($this->file) - 4) != 'json')
			throw new FileException($this->file, 'File must be a json file');
	}
	
	/**
	 * @param string|array|\stdClass $data
	 */
	private function write(array $data)
	{
		$encodedData = json_encode($data, JSON_PRETTY_PRINT);
		$this->validateFile();
		
		if (file_put_contents($this->file, $encodedData, LOCK_EX) === false)
		{
			throw new FileException($this->file, 'Failed to save data to file');
		}
	}
	
	/**
	 * @return array
	 */
	private function read()
	{
		$this->validateFile();
		$content = file_get_contents($this->file);
		
		if ($content === false)
			throw new FileException($this->file, 'Failed to read data from file');
		
		$data = ($content ? json_decode($content, true) : []);
		
		if ($data === false || (!is_array($data) && !($data instanceof \stdClass)))
			throw new FileException($this->file, 'Unexpected data in file: ' . $content);
		
		return $data;
	}
		
		
		/**
	 * @param string $file
	 * @throws FileException
	 */
	public function setTarget($file)
	{
		$this->file = $file;
		$this->validateFile();
	}
	
	/**
	 * @param string $className LiteObject class name.
	 * @return LiteObject
	 * @throws FileException
	 */
	public function loadFile($className)
	{
		$this->validateFile();
		
		/** @var LiteObject $object */
		$object = new $className;
		
		return $object->fromArray($this->read());
	}
	
	/**
	 * @param string $className LiteObject class name.
	 * @return LiteObject[]
	 * @throws FileException
	 */
	public function loadAll($className)
	{
		$this->validateFile();
		
		/** @var LiteObject $className */
		return $className::allFromArray($this->read());
	}
	
	/**
	 * @param LiteObject $fileObject
	 * @throws FileException
	 */
	public function save(LiteObject $fileObject)
	{
		$this->write($fileObject->toArray());
	}
	
	/**
	 * @param LiteObject[] $fileObjects
	 * @throws FileException
	 */
	public function saveAll(array $fileObjects)
	{
		$this->write(LiteObject::allToArray($fileObjects));
	}
}