<?php
namespace Wave\Base;


use Wave\Scope;
use Wave\DummyLog;


Scope::instance()->skeleton(ILog::class, DummyLog::class);