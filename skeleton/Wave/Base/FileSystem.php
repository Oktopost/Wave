<?php
namespace Wave\Base\FileSystem;


use Wave\Scope;
use Wave\FileSystem\JsonFile;
use Wave\FileSystem\TempDirectory;


Scope::skeleton(IJsonFile::class, JsonFile::class);
Scope::skeleton(ITempDirectory::class, TempDirectory::class);