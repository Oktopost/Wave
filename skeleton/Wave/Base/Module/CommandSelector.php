<?php
namespace Wave\Base\Module\CommandSelector;


use Skeleton\Type;
use Wave\Scope;
use Wave\Base\Module\CommandSelector;
use Wave\Module\CommandSelector\TypeValidatorFactory;
use Wave\Module\CommandSelector\CommandSelectValidator;


Scope::skeleton(ICommandSelector::class, CommandSelector::class);
Scope::skeleton(ICommandSelectValidator::class, CommandSelectValidator::class);
Scope::skeleton(ICommandTypeSelectValidatorFactory::class, TypeValidatorFactory::class);