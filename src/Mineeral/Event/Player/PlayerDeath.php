<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\Player;

use pocketmine\utils\Config;

use pocketmine\event\player\PlayerDeathEvent;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;

use Mineeral\Main;

use Mineeral\Event\Entity\EntityDamageByEntity;

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
                $event->setDeathMessage(Main::PREFIX_KILL . $name . " §fa été tué par§4 ". $dname);
                $player->teleport(Main::getInstance()->getServer()->getLevelByName("Arene")->getSafeSpawn());
                $damager->setHealth(20);

                $kill = new Config(Main::getInstance()->getDataFolder() . "/Infos/Kill.json", Config::JSON);
                $death = new Config(Main::getInstance()->getDataFolder() . "/Infos/Death.json", Config::JSON);
                $money = new Config(Main::getInstance()->getDataFolder() . "/Infos/Money.json", Config::JSON);

                Main::setConfig($damager, $kill, Main::onConfig($damager, "kill") + 1);
                Main::setConfig($damager, $money, Main::onConfig($damager, "money") + 10);
                Main::setConfig($player, $death, Main::onConfig($player, "death") + 1);

                EntityDamageByEntity::time($damager, "del");
                EntityDamageByEntity::time($player, "del");

            }
        }
    }
}
