<?php

namespace Mineeral\Commands\Player;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use Mineeral\Main;
use pocketmine\Server;
use onebone\economyapi\EconomyAPI;

class Store extends PluginCommand{
    private $plugin;

    public function __construct(Main $plugin){
        parent::__construct("shop", $plugin);
        $this->setAliases(["store"]);
        $this->plugin = $plugin;
    }
    public function execute(CommandSender $player, string $commandLabel, array $args){
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $money = EconomyAPI::getInstance()->myMoney($player);
    }

}
