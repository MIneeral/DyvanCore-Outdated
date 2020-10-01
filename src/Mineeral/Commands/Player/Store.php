<?php

namespace Mineeral\Commands\Player;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use Mineeral\Main;

class Store extends Command{

    public function __construct()
    {

        parent::__construct("shop", "Permet d'affiché le shop");
        $this->setAliases(["store"]);

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player) return $sender->sendMessage(Main::getPrefix("important") . "Commande utilisable seulement en jeu !");

        return true;
    }

}
