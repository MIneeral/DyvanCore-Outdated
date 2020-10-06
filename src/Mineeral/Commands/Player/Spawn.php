<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;
use Mineeral\Utils\Message;

class Spawn extends Command{

    public function __construct()
    {

        parent::__construct("spawn", "Vous permez de vous téléporté au spawn !");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) {

            $sender->teleport(Main::getInstance()->getServer()->getLevelByName("Arene")->getSafeSpawn());
            $sender->sendMessage(Message::TELEPORT . "au spawn");

        }
        else return $sender->sendMessage(Message::ONLY_GAME);

        return true;

    }
}
