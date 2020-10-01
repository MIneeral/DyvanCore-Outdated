<?php

namespace Mineeral\Commands\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class Spawn extends Command{

    public function __construct()
    {

        parent::__construct("spawn", "Vous permez de vous téléporté au spawn !");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player) return $sender->sendMessage(Main::getPrefix("important") . "Commande utilisable seulement en jeu !");

        $sender->teleport(Main::getInstance()->getServer()->getLevelByName("Arene")->getSafeSpawn());
        $sender->sendMessage(Main::getPrefix("good") . " Vous avez bien était téléporter au spawn");

    }
}
