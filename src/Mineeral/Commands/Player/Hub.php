<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class Hub extends Command{

    public function __construct()
    {

        parent::__construct("hub", "Vous permez de vous téléporté au hub !");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) {

            $sender->teleport(Main::getInstance()->getServer()->getLevelByName("Arene")->getSafeSpawn());
            $sender->sendMessage(Main::PREFIX_GOOD . "Vous avez bien était téléporter au hub");

        }
        else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;

    }
}
