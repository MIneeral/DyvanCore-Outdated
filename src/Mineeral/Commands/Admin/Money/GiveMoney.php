<?php

namespace Mineeral\Commands\Admin\Money;

use pocketmine\Player;

use pocketmine\utils\C;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;
use Mineeral\Utils\Message;
use Mineeral\Utils\Config;

class GiveMoney extends Command{

    public function __construct()
    {

        parent::__construct("givemoney", "Vous permez de give de l'argent à une personne");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        if($sender instanceof Player){

            if(!$args || !$args[0] || !$args[1]) $sender->sendMessage(Main::PREFIX_IMPORTANT . "Usage : /givemoney <player> <montant>");

            else {

                if(Main::getInstance()->getServer()->getPlayer($args[0]) instanceof Player){

                    $p = Main::getInstance()->getServer()->getPlayer($args[0]);
                    $money = new C(Main::getInstance()->getDataFolder() . "/Infos/Money.json", C::JSON);
                    Config::setConfig($p, $money, Config::onConfig($p, "money") + intval($args[1]));
                    $sender->sendMessage(Message::PREFIX_IMPORTANT . "Tu as bien donné §4" . $args[1] . " §rà " . $p->getName());
                    $p->sendMessage(Message::PREFIX_IMPORTANT . "Tu as été give de §4" . $args[1] . " §rpar " . $sender->getName());

                }
                else $sender->sendMessage(Message::NO_PLAYER);
            }
        }
        else $sender->sendMessage(Message::ONLY_GAME);

        return true;

    }
}
