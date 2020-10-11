<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\Player;

use pocketmine\utils\Config as C;

use pocketmine\event\player\PlayerDeathEvent;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;

use Mineeral\Main;
use Mineeral\Utils\Config;

use Mineeral\Constants\Event;

use Mineeral\Event\Entity\EntityDamageByEntity;

class PlayerDeath implements Listener
{

    public function PlayerDeathEvent(PlayerDeathEvent $event)
    {

        $event->setDrops([]);
        $player = $event->getPlayer();
        $name = $player->getName();
        $cause = $player->getLastDamageCause()->getCause();

        if($cause == EntityDamageEvent::CAUSE_ENTITY_ATTACK){

            $damager = $player->getLastDamageCause()->getDamager();
        
            if($damager instanceof Player && $player instanceof Player) {

                $dname = $damager->getName();
                $event->setDeathMessage(Event::KILL . $name . "§f a été tué par §4". $dname);
                $player->teleport(Main::getInstance()->getServer()->getLevelByName("Arene")->getSafeSpawn());
                $damager->setHealth(20);

                EntityDamageByEntity::time($damager, "del");
                EntityDamageByEntity::time($player, "del");

                $kill_db = new C(Main::getInstance()->getDataFolder() . "/Infos/Kill.json", C::JSON);
                $death_db = new C(Main::getInstance()->getDataFolder() . "/Infos/Death.json", C::JSON);
                $money_db = new C(Main::getInstance()->getDataFolder() . "/Infos/Money.json", C::JSON);
                $kill = Config::onConfig($damager, "kill");
                $money = Config::onConfig($damager, "money");
                $death = Config::onConfig($player, "death");
                Config::setConfig($damager, $kill_db, $kill + 1);
                Config::setConfig($damager, $money_db, $money + 10);
                Config::setConfig($player, $death_db, $death + 1);

                return true;

            }
        }

        return true;
    }
}
