<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\utils\Config;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class TopDeath extends Command{

    public function __construct()
    {

        parent::__construct("td", "Permet d'affiché le top des deaths");
        $this->setAliases(["topdeath"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) TopDeath::sendTopDeath($sender);
        else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;
    }

    public static function sendTopDeath(Player $player)
    {
        
        $death = new Config(Main::getInstance()->getDataFolder() . "/Infos/Death.json", Config::JSON);
        $alldeaths = $death->getAll();

        $top = 1;
        $player->sendMessage(Main::PREFIX_IMPORTANT . "Top §410§f des personnes les plus morts !\n");

        arsort($alldeaths);
        foreach ($alldeaths as $name => $value){
            if($top > 10)break;
                $player->sendMessage("§8»§4 #{$top} §c{$name}§f avec §c{$value}§f mort(s)§8 »\n");
                $top ++;
        }
    }
}
