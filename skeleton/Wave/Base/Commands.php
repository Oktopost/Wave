<?php
namespace Wave\Base\Commands;


use Wave\Scope;
use Wave\Commands;


Scope::skeleton(IQueue::class,			Commands\Queue::class);
Scope::skeleton(IManager::class,		Commands\Manager::class);
Scope::skeleton(ICommandCreator::class, Commands\CommandCreator::class);
Scope::skeleton(ICommandFactory::class, Commands\CommandFactory::class);