<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\CommandSender;
use pocketmine\command\Command as Cmd;

use Mineeral\Main;

use Mineeral\Constants\Command;

class Store extends Cmd{

    public function __construct()
    {

        parent::__construct("shop", "Permet d'affiché le shop");
        $this->setAliases(["store"]);

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) $msg = 0;
        else $sender->sendMessage(Command::ONLY_GAME);

        return true;

    }

}
