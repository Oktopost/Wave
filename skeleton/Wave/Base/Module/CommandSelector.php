<?php
namespace Wave\Base\Module\CommandSelector;


use Wave\Scope;
use Wave\Base\Commands\ICommandManager;
use Wave\Module\CommandSelector\TypeValidatorFactory;
use Wave\Module\CommandSelector\CommandSelectValidator;
use Wave\Commands\CommandManager;


Scope::skeleton(ICommandManager::class,						CommandManager::class);
Scope::skeleton(ICommandSelectValidator::class,				CommandSelectValidator::class);
Scope::skeleton(ICommandTypeSelectValidatorFactory::class,	TypeValidatorFactory::class);