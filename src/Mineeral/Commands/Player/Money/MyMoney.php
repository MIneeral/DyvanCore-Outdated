<?php

namespace Mineeral\Commands\Player\Money;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;
use Mineeral\Utils\Config;
use Mineeral\Utils\Message;

class MyMoney extends Command{

    public function __construct()
    {

        parent::__construct("money", "Vous permez de voir votre argent");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        
        if($sender instanceof Player) $sender->sendMessage(Main::PREFIX_IMPORTANT . "Vous avez §4" . Config::onConfig($sender, "money") . "");
        else $sender->sendMessage(Message::ONLY_GAME);

        return true;

    }
}
