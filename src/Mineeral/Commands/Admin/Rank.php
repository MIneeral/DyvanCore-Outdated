<?php

namespace Mineeral\Commands\Admin;

use pocketmine\Player;
use pocketmine\entity\Entity;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\level\Position;

use Mineeral\Main;
use Mineeral\Utils\Message;
use Mineeral\Forms\Form\AdminForm;

class Rank extends Command{

    public function __construct()
    {

        parent::__construct("rank", "Permet de mettre un rank à une personne !");
        $this->setAliases(["ru", "rankup"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) {

            if(!$sender->isOp()) return $sender->sendMessage(Message::NO_PERM);
        
            AdminForm::Ranks($sender);

        }
        else $sender->sendMessage(Message::ONLY_GAME);

        return true;
    }
}
