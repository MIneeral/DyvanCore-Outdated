<?php

namespace Mineeral\Commands\Admin\Money;

use pocketmine\Player;

use pocketmine\utils\Config as C;

use pocketmine\command\Command as Cmd;
use pocketmine\command\CommandSender;

use Mineeral\Main;
use Mineeral\Utils\Config;

use Mineeral\Constants\Prefix;
use Mineeral\Constants\Command;

class RemoveMoney extends Cmd{

    public function __construct()
    {

        parent::__construct("removemoney", "Vous permez de retiré de l'argent à une personne");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        if($sender instanceof Player){

            if(!$sender->isOp()) return $sender->sendMessage(Command::NO_PERM);
            if(!$args || !$args[0] || !$args[1]) $sender->sendMessage(Prefix::IMPORTANT . "Usage : /removemoney <player> <montant>");

            else {

                if(Main::getInstance()->getServer()->getPlayer($args[0]) instanceof Player){

                    $p = Main::getInstance()->getServer()->getPlayer($args[0]);

                    $money = new C(Main::getInstance()->getDataFolder() . "/Infos/Money.json", C::JSON);
                    Config::setConfig($p, $money, Config::onConfig($p, "money") - intval($args[1]));
                    $sender->sendMessage(Prefix::IMPORTANT . "Tu as bien retiré §4" . $args[1] . " §rà " . $p->getName());

                }
                else $sender->sendMessage(Command::NO_PLAYER);
            }
        }
        else $sender->sendMessage(Command::ONLY_GAME);

        return true;

    }
}
