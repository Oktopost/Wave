<?php
namespace Wave\Base\Module\CommandSelector;


use Skeleton\Type;
use Wave\Scope;
use Wave\Base\Module\CommandSelector;
use Wave\Module\CommandSelector\TypeValidatorFactory;
use Wave\Module\CommandSelector\CommandSelectValidator;


Scope::instance()->skeleton(ICommandSelector::class, CommandSelector::class);
Scope::instance()->skeleton(ICommandSelectValidator::class, CommandSelectValidator::class);
Scope::instance()->skeleton(ICommandTypeSelectValidatorFactory::class, TypeValidatorFactory::class);