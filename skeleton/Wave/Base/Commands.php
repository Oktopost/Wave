<?php
namespace Wave\Base\Commands;


use Wave\Scope;
use Wave\Commands\CommandFactory;


Scope::skeleton(ICommandFactory::class, CommandFactory::class);