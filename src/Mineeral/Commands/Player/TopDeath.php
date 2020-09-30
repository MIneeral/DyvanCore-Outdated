<?php

namespace Mineeral\Commands\Player;

use Mineeral\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;

class TopDeath extends PluginCommand{

    private $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("td", $plugin);
        $this->setAliases(["topdeath"]);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player)return $sender->sendMessage("Commande utilisable seulement en jeu !");
        $this->sendTopDeath($sender);
        return true;
    }

    public function sendTopDeath(Player $player){
    $config = $this->plugin->death;
    $config = $config->getAll();
    arsort($config);
    $top = 1;
    $player->sendMessage("§f[§c!§f]§f Top §410§f des personnes les plus morts !\n");
        foreach ($config as $name => $value){
            if($top == 11)break;
            $player->sendMessage("§8»§4 #{$top} §c{$name}§f avec §c{$value}§f mort(s)§8 »\n");
        $top ++;
        }
    }
}
