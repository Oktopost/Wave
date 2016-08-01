<?php
namespace Wave\Base\FileSystem;


use Wave\Base\FileSystem\Data\ILocalPackages;


/**
 * @skeleton
 */
interface IData
{
	/**
	 * @return ILocalPackages
	 */
	public function localPackages();
}