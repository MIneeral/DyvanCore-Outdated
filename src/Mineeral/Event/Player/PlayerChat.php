<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

use Mineeral\Main;

class PlayerChat implements Listener
{

    public const RANKS = 
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
        Main::getInstance()->getServer()->broadcastMessage(
            PlayerChat::RANKS[Main::onConfig($event->getPlayer(), "rank")] . 
            " §f". $event->getPlayer()->getName() . " : " . $event->getMessage()
        );

        $event->setCancelled();
    }
}
