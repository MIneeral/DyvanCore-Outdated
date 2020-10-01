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
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) $msg = 0;
        else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;

    }

}
