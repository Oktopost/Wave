<?php
namespace Wave\Base;


use Wave\Scope;


use Wave\Lock;
use Wave\DummyLog;

Scope::skeleton(ILog::class, DummyLog::class);
Scope::skeleton(ILock::class, Lock::class);


use Wave\Base\Module\IBuild;
use Wave\Module\BuildModule;

Scope::skeleton(IBuild::class, BuildModule::class);