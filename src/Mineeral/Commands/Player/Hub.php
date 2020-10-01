<?php

namespace Mineeral\Commands\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class Hub extends Command{

    public function __construct()
    {

        parent::__construct("hub", "Vous permez de vous téléporté au hub !");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player) return $sender->sendMessage(Main::PREFIX_GOOD . "§fCommande utilisable seulement en jeu !");

        $sender->teleport(Main::getInstance()->getServer()->getLevelByName("Arene")->getSafeSpawn());
        $sender->sendMessage(Main::PREFIX_GOOD . "Vous avez bien était téléporter au hub");

    }
}
