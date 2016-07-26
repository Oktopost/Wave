<?php
namespace Wave\Base\FileSystem;


use Wave\Scope;
use Wave\FileSystem\JsonFile;
use Wave\FileSystem\TempDirectory;


Scope::instance()->skeleton(IJsonFile::class, JsonFile::class);
Scope::instance()->skeleton(ITempDirectory::class, TempDirectory::class);