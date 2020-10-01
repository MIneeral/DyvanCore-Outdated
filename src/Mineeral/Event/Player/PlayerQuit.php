<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

use Mineeral\Main;

use Mineeral\Event\Entity\EntityDamageByEntity;

class PlayerQuit implements Listener
{

    public function PlayerQuitEvent(PlayerQuitEvent $ev) : void 
    {
        $player = $ev->getPlayer();
        $time = EntityDamageByEntity::Time($player, "get");

        if(isset($time) && time() < $time) $player->kill();
        
        $ev->setQuitMessage("");
        Main::getInstance()->getServer()->broadcastPopup(Main::getPrefix("quit") . $player->getName());

    }
}
