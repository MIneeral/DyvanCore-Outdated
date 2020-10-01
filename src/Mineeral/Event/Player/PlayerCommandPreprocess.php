<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\Player;

use pocketmine\event\player\PlayerCommandPreprocessEvent;

use Mineeral\Main;

use Mineeral\Event\Entity\EntityDamageByEntity;

class PlayerCommandPreprocess implements Listener
{

    public function PlayerDeath(PlayerCommandPreprocessEvent $event) : void 
    {
        $player = $event->getPlayer();

        $time = EntityDamageByEntity::time($player, "get");

        if($event->getMessage()[0] === "/" and isset($time) and time() < $time){

            $player->sendMessage(Main::PREFIX_IMPORTANT . "Vous êtes encore en combat !");
            $event->setCancelled();

        }
    }
}
