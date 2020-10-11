<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\Player;

use pocketmine\event\player\PlayerRespawnEvent;

use Mineeral\Main;

class PlayerRespawn implements Listener
{

    public function PlayerRespawnEvent(PlayerRespawnEvent $event)
    {

        $event->setRespawnPosition(Main::getInstance()->getServer()->getLevelByName("Arene")->getSafeSpawn());
        $event->getPlayer()->setGamemode(2);

    }
}
