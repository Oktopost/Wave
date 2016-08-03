<?php
namespace Wave\Base\Module\CommandSelector;


use Skeleton\Type;
use Wave\Base\Commands\ICommandManager;
use Wave\Scope;
use Wave\Commands\CommandManager;
use Wave\Module\CommandSelector\TypeValidatorFactory;
use Wave\Module\CommandSelector\CommandSelectValidator;


Scope::skeleton(ICommandManager::class,					CommandManager::class);
Scope::skeleton(ICommandSelectValidator::class,				CommandSelectValidator::class);
Scope::skeleton(ICommandTypeSelectValidatorFactory::class,	TypeValidatorFactory::class);