<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\Command as Cmd;
use pocketmine\command\CommandSender;

use Mineeral\Main;

use Mineeral\Constants\Command;

class Hub extends Cmd{

    public function __construct()
    {

        parent::__construct("hub", "Vous permez de vous téléporté au hub !");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) {

            $sender->teleport(Main::getInstance()->getServer()->getLevelByName("Arene")->getSafeSpawn());
            $sender->sendMessage(Command::TELEPORT . "au hub");

        }
        else $sender->sendMessage(Command::ONLY_GAME);

        return true;

    }
}
