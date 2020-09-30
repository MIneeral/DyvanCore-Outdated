<?php

namespace Mineeral\Commands\Player;

use Mineeral\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class TopKill extends Command{

    public function __construct()
    {

        parent::__construct("tk", "Permet d'affiché le top des kills");
        $this->setAliases(["topkill"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player) return $sender->sendMessage("Commande utilisable seulement en jeu !");
        return TopKill::sendTopKill($sender);
    }

    public static function sendTopKill(Player $player)
    {

        $config = Main::onConfig("kill")->getAll();
        $top = 1;
        $player->sendMessage("§f[§c!§f]§f Top §410§f des personnes qui ont le tuer de personnes !\n");
        
        arsort($config);
        foreach ($config as $name => $value){
            if($top > 10) break;
                $player->sendMessage("§8»§4 #{$top} §c{$name}§f avec §c{$value}§f mort(s)§8 »\n");
                $top ++;
        }
    }
}
