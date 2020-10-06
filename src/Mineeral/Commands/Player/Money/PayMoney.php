<?php

namespace Mineeral\Commands\Player\Money;

use pocketmine\Player;

use pocketmine\utils\Config as C;

use pocketmine\command\Command as Cmd;
use pocketmine\command\CommandSender;

use Mineeral\Main;
use Mineeral\Utils\Config;

use Mineeral\Constants\Prefix;
use Mineeral\Constants\Command;

class PayMoney extends Cmd{

    public function __construct()
    {

        parent::__construct("pay", "Vous permez de payé à une personne de l'argent");
        $this->setAliases(["paymoney"]);

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        if($sender instanceof Player){

            if(!$args || !$args[0] || !$args[1]) $sender->sendMessage(Prefix::IMPORTANT . "Usage : /pay <player> <montant>");

            else {

                if(Main::getInstance()->getServer()->getPlayer($args[0]) instanceof Player){

                    $p = Main::getInstance()->getServer()->getPlayer($args[0]);

                    $money = new C(Main::getInstance()->getDataFolder() . "/Infos/Money.json", C::JSON);

                    Config::setConfig($sender, $money, Main::onConfig($sender, "money") - intval($args[1]));
                    Config::setConfig($p, $money, Main::onConfig($p, "money") + intval($args[1]));

                    $sender->sendMessage(Prefix::IMPORTANT . "Tu as bien payé §4" . $args[1] . "§r à". $p->getName());
                    $p->sendMessage(Prefix::IMPORTANT . "Tu as été payé §4" . $args[1] . "§r par". $sender->getName());

                }
                else $sender->sendMessage(Command::NO_PLAYER);
            }
        }
        else $sender->sendMessage(Command::ONLY_GAME);

        return true;

    }
}
