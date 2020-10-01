<?php

namespace Mineeral\Commands\Admin\Money;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class SetMoney extends Command{

    public function __construct()
    {

        parent::__construct("removemoney", "Vous permez de set l'argent d'une personne");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        if($sender instanceof Player){

            if(!$args || !$args[0] || !$args[1]) $sender->sendMessage(Main::PREFIX_IMPORTANT . "Usage : /setmoney <player> <montant>");

            else {

                if(Main::getInstance()->getServer()->getPlayer($args[0]) instanceof Player){

                    $p = Main::getInstance()->getServer()->getPlayer($args[0]);

                    Main::setConfig($p, "int", "money", intval($args[1]));
                    $sender->sendMessage(Main::PREFIX_IMPORTANT . "Tu as bien set " . $p->getName() . " à §4" . Main::onConfig($p, "money") . "");

                }
                else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Le joueur n'existe pas !");
            }
        }
        else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;

    }
}
