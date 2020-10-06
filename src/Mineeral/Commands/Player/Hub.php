<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;
use Mineeral\Utils\Message;

class Hub extends Command{

    public function __construct()
    {

        parent::__construct("hub", "Vous permez de vous téléporté au hub !");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) {

            $sender->teleport(Main::getInstance()->getServer()->getLevelByName("Arene")->getSafeSpawn());
            $sender->sendMessage(Message::TELEPORT . "au hub");

        }
        else $sender->sendMessage(Message::ONLY_GAME);

        return true;

    }
}
