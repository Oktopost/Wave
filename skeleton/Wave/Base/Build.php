<?php
namespace Wave\Base\Source;


use Wave\Scope;
use Wave\Source\SourceManagerFactory;


Scope::instance()->skeleton(ISourceManagerFactory::class, SourceManagerFactory::class);