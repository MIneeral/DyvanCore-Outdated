<?php

namespace Mineeral\Event\Player;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

use Mineeral\Main;
use Mineeral\Utils\Config;
use Mineeral\Utils\Rank;
use Mineeral\Utils\Message;

class PlayerChat implements Listener
{
    private static $time = [];

    private const TIME = 3;

    public function PlayerChatEvent(PlayerChatEvent $event)
    {

        if(!isset(PlayerChat::$time[$event->getPlayer()->getName()]) || time() >= PlayerChat::$time[$event->getPlayer()->getName()]){

            Main::getInstance()->getServer()->broadcastMessage(
                Rank::RANK_TEXT[Config::onConfig($event->getPlayer(), "rank")] . 
                " §f". $event->getPlayer()->getName() . " : " . $event->getMessage()
            );
            $event->setCancelled();
            PlayerChat::$time[$event->getPlayer()->getName()] = time() + PlayerChat::TIME;

        } else {
            
            if(PlayerChat::$time[$event->getPlayer()->getName()] - time() < PlayerChat::TIME){

                $event->getPlayer()->sendMessage(Message::NO_SPAM);

            }

            $event->setCancelled();

        }
    }
}
