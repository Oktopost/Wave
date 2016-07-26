<?php
namespace Wave\Base;


use Wave\Scope;


use Wave\Lock;
use Wave\DummyLog;

Scope::instance()->skeleton(ILog::class, DummyLog::class);
Scope::instance()->skeleton(ILock::class, Lock::class);