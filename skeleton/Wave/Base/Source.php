<?php
namespace Wave\Base\Source;


use Wave\Scope;
use Wave\Source\Source;
use Wave\Source\SourceConnectorFactory;


Scope::instance()->skeleton(ISource::class, Source::class);
Scope::instance()->skeleton(ISourceConnectorFactory::class, SourceConnectorFactory::class);
