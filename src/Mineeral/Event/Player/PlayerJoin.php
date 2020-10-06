<?php

namespace Mineeral\Event\Player;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Main;

use Mineeral\Constants\Rank;
use Mineeral\Constants\Event;

class PlayerJoin implements Listener
{
    public static $time = [];

    public function PlayerJoinEvent(PlayerJoinEvent $event) : void 
    {

        $player = $event->getPlayer();
        $event->setJoinMessage("");

        if(!$player->hasPlayedBefore()) PlayerJoin::newPlayer($player);

        Main::getInstance()->getServer()->broadcastPopup(Event::JOIN . $player->getName());
        if(isset(Rank::RANK_NAMETAG[Main::onConfig($player, "rank")])) $player->setNameTag(Rank::RANK_NAMETAG[Main::onConfig($player, "rank")] . " §f" . $player->getName());
        $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_GHAST_SHOOT);

        PlayerJoin::$time[$player->getName()] = time();

    }

    public static function getTime(Player $player) : int
    {

        return PlayerJoin::$time[$player->getName()];

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
            "tempban",
            "time",
        ];

        foreach($nbt as $stat){

            Main::onConfig($player, $stat);

        }

        $player->sendMessage(Event::WELCOME);

    }
}
