<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

use Mineeral\Main;

use Mineeral\Event\Entity\EntityDamageByEntity;

class PlayerQuit implements Listener
{

    public function PlayerQuitEvent(PlayerQuitEvent $event) : void 
    {
        
        $player = $event->getPlayer();
        $time = EntityDamageByEntity::time($player, "get");

        if(isset($time) && time() < $time) $player->kill();
        
        $event->setQuitMessage("");
        Main::getInstance()->getServer()->broadcastPopup(Main::PREFIX_QUIT . $player->getName());

        Main::setConfig($player, "int", "time", PlayerJoin::getTime($player) - time() + Main::onConfig($player, "time"));

    }
}
