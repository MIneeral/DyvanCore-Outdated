<?php

namespace Mineeral\Commands\Admin\Money;

use pocketmine\Player;

use pocketmine\utils\C;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;
use Mineeral\Utils\Config;
use Mineeral\Utils\Message;

class SetMoney extends Command{

    public function __construct()
    {

        parent::__construct("setmoney", "Vous permez de set l'argent d'une personne");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        if($sender instanceof Player){

            if(!$args || !$args[0] || !$args[1]) $sender->sendMessage(Message::PREFIX_IMPORTANT . "Usage : /setmoney <player> <montant>");

            else {

                if(Main::getInstance()->getServer()->getPlayer($args[0]) instanceof Player){

                    $p = Main::getInstance()->getServer()->getPlayer($args[0]);
                    $money = new C(Main::getInstance()->getDataFolder() . "/Infos/Money.json", C::JSON);
                    Config::setConfig($p, $money, intval($args[1]));
                    $sender->sendMessage(Message::PREFIX_IMPORTANT . "Tu as bien set " . $p->getName() . " à §4" . $args[1] . "");

                }
                else $sender->sendMessage(Message::NO_PLAYER);
            }
        }
        else $sender->sendMessage(Message::ONLY_GAME);

        return true;

    }
}
