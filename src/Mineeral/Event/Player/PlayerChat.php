<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

use Mineeral\Main;

class PlayerChat implements Listener
{
    private static $time = [];

    private const TIME = 3;

    private const RANKS = 
    [
        "Player" => "§e[Player]",
        "Saturne" => "§d[Saturne]",
        "Saturne-Plus" => "§5[Saturne+]",
        "Eris" => "§9[Eris]",
        "Guide" => "§a[Guide]",
        "Modo" => "§c[Modo]",
        "Super-Modo" => "§6[Super-Modo]",
        "Admin" => "§3[Admin]",
        "Owner" => "§4[Owner]"
    ];

    public function PlayerChatEvent(PlayerChatEvent $event)
    {

        if(!isset(PlayerChat::$time[$event->getPlayer()->getName()]) || time() >= PlayerChat::$time[$event->getPlayer()->getName()]){

            Main::getInstance()->getServer()->broadcastMessage(
                PlayerChat::RANKS[Main::onConfig($event->getPlayer(), "rank")] . 
                " §f". $event->getPlayer()->getName() . " : " . $event->getMessage()
            );
            $event->setCancelled();
            PlayerChat::$time[$event->getPlayer()->getName()] = time() + PlayerChat::TIME;

        } else {
            
            if(PlayerChat::$time[$event->getPlayer()->getName()] - time() < PlayerChat::TIME){

                $event->getPlayer()->sendMessage(Main::PREFIX_BAD . "Merci de ne pas spam de message !");

            }

            $event->setCancelled();

        }
    }
}
