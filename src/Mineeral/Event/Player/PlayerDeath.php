<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\Player;

use pocketmine\event\player\PlayerDeathEvent;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;

use onebone\economyapi\EconomyAPI;

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
                $event->setDeathMessage("§c» §4" . $name . " §fa été tué par§4 ". $dname);
                $player->teleport($this->getServer()->getLevelByName("Arene")->getSafeSpawn());
                EconomyAPI::getInstance()->addMoney($damager, "10");
                $damager->setHealth(20);
                Main::onConfig("kill")->set($dname, Main::onConfig("kill")->get($dname) + 1)->save();
                Main::onConfig("death")->set($name, Main::onConfig("death")->get($name) + 1)->save();

            }
        }
    }
}
