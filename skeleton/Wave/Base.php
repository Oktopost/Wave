<?php
namespace Wave\Base;


use Wave\Scope;


use Wave\Lock;
use Wave\DummyLog;

Scope::skeleton(ILog::class, DummyLog::class);
Scope::skeleton(ILock::class, Lock::class);