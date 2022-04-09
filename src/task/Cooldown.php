<?php

declare(strict_types=1);

namespace NeiroNetwork\AttackDelayController\task;

use NeiroNetwork\AttackDelayController\Main as ADC;
use pocketmine\entity\Entity;
use pocketmine\scheduler\Task;

class Cooldown extends Task{
	
	private Entity $entity;
	
	public function __construct(Entity $entity){
		$this->entity = $entity;
	}
	
	public function onRun() : void{
		if(isset(ADC::$cooltime[$this->entity->getName()])){
			ADC::$cooltime[$this->entity->getName()] = 0;
		}
	}
}
