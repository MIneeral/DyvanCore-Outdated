<?php

namespace Mineeral\Commands\Admin;

use pocketmine\Player;
use pocketmine\entity\Entity;

use pocketmine\command\Command as Cmd;
use pocketmine\command\CommandSender;

use pocketmine\level\Position;

use Mineeral\Main;

use Mineeral\Constants\Command;

use Mineeral\Forms\Form\AdminForm;

class Rank extends Cmd{

    public function __construct()
    {

        parent::__construct("rank", "Permet de mettre un rank à une personne !");
        $this->setAliases(["ru", "rankup"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) {

            if(!$sender->isOp()) return $sender->sendMessage(Command::NO_PERM);
        
            AdminForm::Ranks($sender);

        }
        else $sender->sendMessage(Command::ONLY_GAME);

        return true;
    }
}
