<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\Player;

use pocketmine\utils\C;

use pocketmine\event\player\PlayerDeathEvent;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;

use Mineeral\Main;
use Mineeral\Utils\Config;
use Mineeral\Utils\Message;
use Mineeral\Event\Entity\EntityDamageByEntity;

class PlayerDeath implements Listener
{

    public function PlayerDeathEvent(PlayerDeathEvent $event) : void 
    {

        $event->setDrops([]);
        $player = $event->getPlayer();
        $name = $player->getName();
        $cause = $player->getLastDamageCause()->getCause();

        if($cause == EntityDamageEvent::CAUSE_ENTITY_ATTACK){

            $damager = $player->getLastDamageCause()->getDamager();
        
            if($damager instanceof Player) {

                $dname = $damager->getName();
                $event->setDeathMessage(Message::KILL . $name . "§f a été tué par §4". $dname);
                $player->teleport(Main::getInstance()->getServer()->getLevelByName("Arene")->getSafeSpawn());
                $damager->setHealth(20);

                $kill = new C(Main::getInstance()->getDataFolder() . "/Infos/Kill.json", C::JSON);
                $death = new C(Main::getInstance()->getDataFolder() . "/Infos/Death.json", C::JSON);
                $money = new C(Main::getInstance()->getDataFolder() . "/Infos/Money.json", C::JSON);
                Config::setConfig($damager, $kill, Config::onConfig($damager, "kill") + 1);
                Config::setConfig($damager, $money, Config::onConfig($damager, "money") + 10);
                Config::setConfig($player, $death, Config::onConfig($player, "death") + 1);

                EntityDamageByEntity::time($damager, "del");
                EntityDamageByEntity::time($player, "del");

            }
        }
    }
}
