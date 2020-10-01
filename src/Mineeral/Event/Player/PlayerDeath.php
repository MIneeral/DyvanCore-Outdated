<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\Player;

use pocketmine\event\player\PlayerDeathEvent;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;

use Mineeral\Main;

class PlayerDeath implements Listener
{

    public function PlayerDeath(PlayerDeathEvent $event) : void 
    {

        $event->setDrops([]);
        $player = $event->getPlayer();
        $name = $player->getName();
        $cause = $player->getLastDamageCause()->getCause();

        if($cause == EntityDamageEvent::CAUSE_ENTITY_ATTACK){

            $damager = $player->getLastDamageCause()->getDamager();
        
            if($damager instanceof Player) {

                $dname = $damager->getName();
                $event->setDeathMessage(Main::getPrefix("kill") . $name . " §fa été tué par§4 ". $dname);
                $player->teleport($this->getServer()->getLevelByName("Arene")->getSafeSpawn());
                $damager->setHealth(20);

                Main::setConfig($damager, "int", "kill", Main::onConfig($damager, "kill") + 1);
                Main::setConfig($damager, "int", "money", Main::onConfig($damager, "money") + 10);

                Main::setConfig($player, "int", "death", Main::onConfig($player, "death") + 1);

            }
        }
    }
}
