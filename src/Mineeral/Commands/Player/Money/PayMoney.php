<?php

namespace Mineeral\Commands\Player\Money;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class PayMoney extends Command{

    public function __construct()
    {

        parent::__construct("pay", "Vous permez de payé à une personne de l'argent");
        $this->setAliases(["paymoney"]);

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        if($sender instanceof Player){

            if(!$args || !$args[0] || !$args[1]) $sender->sendMessage(Main::PREFIX_IMPORTANT . "Usage : /pay <player> <montant>");

            else {

                if($p = Main::getInstance()->getServer()->getPlayer($args[0]) instanceof Player){

                    Main::setConfig($sender, "int", "money", Main::onConfig($sender, "money") - intval($args[1]));
                    Main::setConfig($p, "int", "money", Main::onConfig($p, "money") + intval($args[1]));

                    $sender->sendMessage(Main::PREFIX_IMPORTANT . "Tu as bien payé §4" . $args[1] . "§r à". $p->getName());
                    $p->sendMessage(Main::PREFIX_IMPORTANT . "Tu as été payé §4" . $args[1] . "§r par". $sender->getName());

                }
                else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Le joueur n'existe pas !");
            }
        }
        else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;

    }
}
