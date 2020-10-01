<?php

namespace Mineeral\Commands\Admin\Money;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class RemoveMoney extends Command{

    public function __construct()
    {

        parent::__construct("removemoney", "Vous permez de retiré de l'argent à une personne");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        if($sender instanceof Player){

            if(!$args || !$args[0] || !$args[1]) $sender->sendMessage(Main::PREFIX_IMPORTANT . "Usage : /removemoney <player> <montant>");

            else {

                if($p = Main::getInstance()->getServer()->getPlayer($args[0]) instanceof Player){

                    Main::setConfig($p, "int", "money", Main::onConfig($p, "money") - intval($args[1]));
                    $sender->sendMessage(Main::PREFIX_IMPORTANT . "Tu as bien retiré §4" . Main::onConfig($p, "money") . " §rà " . $p->getName());

                }
                else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Le joueur n'existe pas !");
            }
        }
        else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;

    }
}
