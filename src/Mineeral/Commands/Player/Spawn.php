<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class Spawn extends Command{

    public function __construct()
    {

        parent::__construct("spawn", "Vous permez de vous téléporté au spawn !");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) {

            $sender->teleport(Main::getInstance()->getServer()->getLevelByName("Arene")->getSafeSpawn());
            $sender->sendMessage(Main::PREFIX_IMPORTANT . " Vous avez bien était téléporter au spawn");

        }
        else return $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;

    }
}
