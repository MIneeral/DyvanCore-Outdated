<?php

namespace Mineeral\Commands\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class Money extends Command{

    public function __construct()
    {

        parent::__construct("money", "Vous permez de vie votre argent");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args){

        if(!$sender instanceof Player) return $sender->sendMessage(Main::getPrefix("important") . "Commande utilisable seulement en jeu !");

        $sender->sendMessage(Main::getPrefix("good") . "Vous avez §4" . Main::onConfig($sender, "money") . "");

    }
}
