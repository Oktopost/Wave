<?php
namespace Wave\Base\Source;


use Wave\Scope;
use Wave\Source\Source;
use Wave\Source\SourceConnectorFactory;


Scope::skeleton(ISource::class, Source::class);
Scope::skeleton(ISourceConnectorFactory::class, SourceConnectorFactory::class);
