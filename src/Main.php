<?php

declare(strict_types=1);

namespace NeiroNetwork\AttackDelayController;

use NeiroNetwork\AttackDelayController\task\Cooldown;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{
	
	public static array $cooltime = [];
	
	public function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	/*
	 * @priority MONITER
	 */
	public function onEntityDamageByEntityEvent(EntityDamageByEntityEvent $event){
		$entity = $event->getEntity();
		if($entity instanceof Player){
			if(self::$cooltime[$entity->getName()] === 1){
				$event->cancel();
			}elseif(!$event->isCancelled()){
				self::$cooltime[$entity->getName()] = 1;
				$this->getScheduler()->scheduleDelayedTask(new Cooldown($entity), 10);
			}
		}
	}
	
	public function onPlayerJoinEvent(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		self::$cooltime[$player->getName()] = 0;
	}
	
	public function onPlayerQuitEvent(PlayerQuitEvent $event){
		$player = $event->getPlayer();
		unset(self::$cooltime[$player->getName()]);
	}
}
