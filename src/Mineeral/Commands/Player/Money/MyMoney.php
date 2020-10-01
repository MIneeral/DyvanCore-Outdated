<?php

namespace Mineeral\Commands\Player\Money;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class MyMoney extends Command{

    public function __construct()
    {

        parent::__construct("money", "Vous permez de voir votre argent");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        
        if($sender instanceof Player) $sender->sendMessage(Main::PREFIX_IMPORTANT . "Vous avez §4" . Main::onConfig($sender, "money") . "");
        else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;

    }
}
