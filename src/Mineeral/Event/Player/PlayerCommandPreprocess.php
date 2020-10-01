<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\Player;

use pocketmine\event\player\PlayerCommandPreprocessEvent;

use Mineeral\Main;

class PlayerCommandPreprocess implements Listener
{

    public function PlayerDeath(PlayerCommandPreprocessEvent $event) : void 
    {

        $player = $event->getPlayer();
        $message = $event->getMessage();

        $messages = explode("", $message);

        if($messages[0] == "/"){

            $player->sendMessage(Main::getPrefix("important") . "Vous etes encore en combat !");
            $event->setCancelled();

        }
    }
}
