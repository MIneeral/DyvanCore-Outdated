<?php

namespace Mineeral\Commands\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class Money extends Command{

    public function __construct()
    {

        parent::__construct("feed", "Vous permez d'être nourris !");

    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args){

        if(!$sender instanceof Player) return $sender->sendMessage("Commande utilisable seulement en jeu !");

        $sender->sendMessage("§f[§c!§f] Vous avez §4" . $sender->getNamedTag()->money . "");

    }
}
