<?php
namespace Wave\Base\Git;


use Wave\Scope;
use Wave\Source\Git\GitAPI;


Scope::instance()->skeleton(IGitAPI::class, GitAPI::class);