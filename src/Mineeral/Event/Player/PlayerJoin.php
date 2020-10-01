<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Main;

class PlayerJoin implements Listener
{
    public const RANKS = 
    [
        "Player" => "&e[P]",
        "Saturne" => "&d[S]",
        "Saturne-Plus" => "&5[S+]",
        "Eris" => "&9[E]",
        "Guide" => "&a[G]",
        "Modo" => "&c[M]",
        "Super-Modo" => "&6[SM]",
        "Admin" => "&3[A]",
        "Owner" => "&4[O]"
    ];

    public function PlayerJoinEvent(PlayerJoinEvent $event) : void 
    {

        $player = $event->getPlayer();
        $event->setJoinMessage("");

        if(!$player->hasPlayedBefore()) PlayerJoin::newPlayer($player);

        Main::getInstance()->getServer()->broadcastPopup(Main::getPrefix("join") . $player->getName());
        $player->setNameTag(PlayerJoin::RANKS[Main::onConfig($player, "rank")] . "&f " . $player->getName());
        $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_GHAST_SHOOT);

    }

    public static function newPlayer(Player $player) : void
    {

        $nbt =  
        [
            "ip",
            "rank",
            "money",
            "kill",
            "death",
            "ban",
            "tempban"
        ];

        foreach($nbt as $stat){

            Main::onConfig($player, $stat);

        }

        $player->sendMessage(Main::getPrefix("good") . "Bienvenue sur §4Dyvan§f PvP-Box !");

    }
}
