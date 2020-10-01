<?php

namespace Mineeral\Commands\Player\Money;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class SeeMoney extends Command{

    public function __construct()
    {

        parent::__construct("seemoney", "Vous permez de voir l'argent d'une personne");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        if($sender instanceof Player){

            if(!$args[0]) $sender->sendMessage(Main::PREFIX_IMPORTANT . "Usage : /seemoney <player>");

            else {

                if($p = Main::getInstance()->getServer()->getPlayer($args[0]) instanceof Player){

                    $sender->sendMessage(Main::PREFIX_IMPORTANT . $p->getName() . " a §4" . Main::onConfig($p, "money") . "");

                }
                else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Le joueur n'existe pas !");
            }
        }
        else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;

    }
}
