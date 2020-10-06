<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\CommandSender;
use pocketmine\command\Command as Cmd;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Main;

use Mineeral\Constants\Command;

class Feed extends Cmd{

    public function __construct()
    {

        parent::__construct("feed", "Vous permez d'être nourris !");

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        if($sender instanceof Player) {

            $sender->addFood(20);
            $sender->addSaturation(20);
            $sender->sendPopup(Command::FEED);
            $sender->getLevel()->broadcastLevelEvent($sender->add(0, $sender->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_USE);

        }
        else $sender->sendMessage(Command::ONLY_GAME);

        return true;

    }
}
