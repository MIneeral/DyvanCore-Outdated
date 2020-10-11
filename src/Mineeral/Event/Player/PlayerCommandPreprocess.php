<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\Player;

use pocketmine\event\player\PlayerCommandPreprocessEvent;

use Mineeral\Main;

use Mineeral\Constants\Event;

use Mineeral\Event\Entity\EntityDamageByEntity;

class PlayerCommandPreprocess implements Listener
{

    public function PlayerCommandPreprocessEvent(PlayerCommandPreprocessEvent $event) : void 
    {
        $player = $event->getPlayer();

        $time = EntityDamageByEntity::time($player, "get");
        var_dump($time);
        if($event->getMessage()[0] === "/" && isset($time) && time() < $time){

            $player->sendTip(Event::FIGHT);
            $event->setCancelled();

        }
    }
}
