<?php
namespace Wave\Base\Target;


use Wave\Scope;
use Wave\Target\LocalStaging;
use Wave\Target\ServerConnectorFactory;


Scope::skeleton(ILocalStaging::class, LocalStaging::class);
Scope::skeleton(IServerConnectorFactory::class, ServerConnectorFactory::class);
