<?php
namespace Wave\Base\FileSystem;


use Wave\Scope;
use Wave\StorageLayer;

use Wave\FileSystem\JsonFile;
use Wave\FileSystem\TempDirectory;
use Wave\FileSystem\JsonFileAccess;
use Wave\FileSystem\LocalFileAccess;


Scope::skeleton(IJsonFile::class,			JsonFile::class);
Scope::skeleton(ITempDirectory::class,		TempDirectory::class);
Scope::skeleton(IJsonFileAccess::class,		JsonFileAccess::class);
Scope::skeleton(ILocalFileAccess::class,	LocalFileAccess::class);