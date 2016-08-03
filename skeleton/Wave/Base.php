<?php
namespace Wave\Base;


use Wave\Base\Module\IDeployment;
use Wave\Base\Module\IStage;
use Wave\Scope;


use Wave\Lock;
use Wave\DummyLog;

Scope::skeleton(ILog::class, DummyLog::class);
Scope::skeleton(ILock::class, Lock::class);


use Wave\Base\Module\IBuild;
use Wave\Module\BuildModule;
use Wave\Module\StageModule;
use Wave\Module\DeployModule;

Scope::skeleton(IBuild::class,		BuildModule::class);
Scope::skeleton(IStage::class,		StageModule::class);
Scope::skeleton(IDeployment::class,	DeployModule::class);


use Wave\Base\StorageLayer\IData;
use Wave\StorageLayer\Data;

Scope::skeleton(IData::class, Data::class);