<?php
namespace Wave\Base\Build;


use Wave\Scope;

use Wave\Build\Phing\PhingBuilder;
use Wave\Base\Build\Phing\IPhingBuilder;


Scope::instance()->skeleton(IPhingBuilder::class, PhingBuilder::class);