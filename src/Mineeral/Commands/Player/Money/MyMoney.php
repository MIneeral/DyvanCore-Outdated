<?php

namespace Mineeral\Commands\Player\Money;

use pocketmine\Player;

use pocketmine\command\Command as Cmd;
use pocketmine\command\CommandSender;

use Mineeral\Main;
use Mineeral\Utils\Config;

use Mineeral\Constants\Prefix;
use Mineeral\Constants\Command;

class MyMoney extends Cmd{

    public function __construct()
    {

        parent::__construct("money", "Vous permez de voir votre argent");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        
        if($sender instanceof Player) $sender->sendMessage(Prefix::IMPORTANT . "Vous avez §4" . Config::onConfig($sender, "money") . "");
        else $sender->sendMessage(Command::ONLY_GAME);

        return true;

    }
}
