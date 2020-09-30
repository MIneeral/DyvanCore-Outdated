<?php

namespace Mineeral\Commands\Player;

use Mineeral\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;

class TopKill extends PluginCommand{

    private $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("tk", $plugin);
        $this->setAliases(["topkill"]);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player)return $sender->sendMessage("Commande utilisable seulement en jeu !");
        $this->sendTopKill($sender);
        return true;
    }

    public function sendTopKill(Player $player){
        $config = $this->plugin->kill;
        $config = $config->getAll();
        arsort($config);
        $top = 1;
    $player->sendMessage("§f[§c!§f]§f Top §410§f des personnes qui ont le tuer de personnes !\n");
        foreach ($config as $name => $value){
            if($top == 11)break;
            $player->sendMessage("§8»§4 #{$top} §c{$name}§f avec §c{$value}§f mort(s)§8 »\n");
        $top ++;
        }
    }
}
