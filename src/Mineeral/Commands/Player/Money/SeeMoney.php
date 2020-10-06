<?php

namespace Mineeral\Commands\Player\Money;

use pocketmine\Player;

use pocketmine\command\Command as Cmd;
use pocketmine\command\CommandSender;

use Mineeral\Main;
use Mineeral\Utils\Config;

use Mineeral\Constants\Prefix;
use Mineeral\Constants\Command;

class SeeMoney extends Cmd{

    public function __construct()
    {

        parent::__construct("seemoney", "Vous permez de voir l'argent d'une personne");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        if($sender instanceof Player){

            if(!$args || !$args[0]) $sender->sendMessage(Prefix::IMPORTANT . "Usage : /seemoney <player>");

            else {

                if(Main::getInstance()->getServer()->getPlayer($args[0]) instanceof Player){

                    $p = Main::getInstance()->getServer()->getPlayer($args[0]);
                    $sender->sendMessage(Prefix::IMPORTANT . $p->getName() . " a §4" . Config::onConfig($p, "money") . "");

                }
                else $sender->sendMessage(Command::NO_PLAYER);
            }
        }
        else $sender->sendMessage(Command::ONLY_GAME);

        return true;

    }
}
