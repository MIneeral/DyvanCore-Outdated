<?php

namespace Mineeral\Event\Entity;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\ProjectileLaunchEvent;

use pocketmine\entity\projectile\EnderPearl;

use pocketmine\item\Item;

use pocketmine\inventory\Inventory;

use Mineeral\Main;

class ProjectileLaunch implements Listener
{   

    /**
     * TODO Fix la suppression de l'enderpearl quand l'event est canceled.
    */

    private static $cooldown = array();

    private static $time = 10;

    public function onLaunch(ProjectileLaunchEvent $event): void
	{
        $player = $event->getEntity()->getOwningEntity();
        
		if ($player instanceof Player) {

            $name = $player->getName();
            $player = Main::getInstance()->getServer()->getPlayer($name);

			if ($event->getEntity() instanceof EnderPearl) {

				if (!isset(ProjectileLaunch::$cooldown[$name]) || time() > ProjectileLaunch::$cooldown[$name]) {

                    ProjectileLaunch::$cooldown[$name] = time() + ProjectileLaunch::$time;
                    
				} else {

                    $player->getInventory()->addItem(Item::get(368, 0, 1));
                    $event->setCancelled();

                }
            }
		}
	}
}
