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
        $time = EntityDamageByEntity::Time($player, "get");
        $message = $event->getMessage();
        $messages = strpos($message, '/');

        if($messages === 0 || $messages === 1){
            if(isset($time) && time() < $time) {
   
                $event->setCancelled();
                $player->sendMessage(Main::getPrefix("important") . "Vous etes encore en combat !");

            }
        }
    }
}
