<?php

namespace Mineeral\Event\Entity;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\ProjectileLaunchEvent;

use pocketmine\item\Item;

class ProjectileLaunch implements Listener
{   

    private static $cooldown = array();

    private static $time = 5;

    public function onLaunch(ProjectileLaunchEvent $event): void
	{
        $player = $event->getEntity()->getOwningEntity();
        
		if ($player instanceof Player) {
			if ($event->getEntity() instanceof EnderPearl) {

				if (isset(ProjectileLaunch::$cooldown[$player->getName()]) && time() < ProjectileLaunch::$cooldown[$player->getName()]) {

                    $event->setCancelled();
                    ProjectileLaunch::$cooldown[$player->getName()] = time() + ProjectileLaunch::$time;
                    
				}
            }
            
		} else {

            $event->setCancelled();

        }
	}
}
