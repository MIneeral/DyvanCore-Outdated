<?php

namespace Mineeral\Commands\Admin;

use pocketmine\Player;
use pocketmine\entity\Entity;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\level\Position;

use Mineeral\Main;
use Mineeral\Forms\Form\AdminForm;

class Rank extends Command{

    public function __construct()
    {

        parent::__construct("rank", "Permet de mettre un rank à une personne !");
        $this->setAliases(["ru", "rankup"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if(!$sender instanceof Player) return $sender->sendMessage(Main::getPrefix("important") . "Commande utilisable seulement en jeu !");
        if(!$sender->hasOp()) return $sender->sendMessage(Main::getPrefix("important") . "Vous n'avez pas la permission d'utiliser cette commande !");
        
        AdminForm::Ranks($sender, $rank, $money);
        return true;
    }
}
