<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

use Mineeral\Main;

class PlayerQuit implements Listener
{

    public function PlayerQuitEvent(PlayerQuitEvent $ev) : void 
    {

        $player = $ev->getPlayer();
        $ev->setQuitMessage("");
        Main::getInstance()->getServer()->broadcastPopup("§f[§c-§f] §4 " . $player->getName());

    }
}
