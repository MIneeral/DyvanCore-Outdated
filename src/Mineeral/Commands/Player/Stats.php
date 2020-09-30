<?php 

namespace Mineeral\Commands\Player;

use pocketmine\command\PluginCommand;
use pocketmine\Server;
use pocketmine\Player;
use Mineeral\Main;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use onebone\economyapi\EconomyAPI;

class Stats extends PluginCommand{

    private $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("stats", $plugin);
        $this->setAliases(["st"]);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        $api =
Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $papi = Server::getInstance()->getPluginManager()->getPlugin("PurePerms");
        $crank = $papi->getUserDataMgr()->getGroup($player)->getName();
        $money = EconomyAPI::getInstance()->myMoney($player);
        $form = $api->createSimpleForm(function (Player $player, int $data = null){
            $result = $data;
            if($result === null){
                return true;
            }
            switch($result){
                case 0;
                    $papi = Server::getInstance()->getPluginManager()->getPlugin("PurePerms");
                    $s = $papi->getGroup("Saturne");
                    $sp = $papi->getGroup("Saturne-Plus");
                    $e = $papi->getGroup("Eris");
                    $p = $papi->getGroup("Player");
                    $crank = $papi->getUserDataMgr()->getGroup($player)->getName();
                    $money = EconomyAPI::getInstance()->myMoney($player);
                    if($crank == "Player"){
                        if($money > 10000){
                            EconomyAPI::getInstance()->reduceMoney($player, "10000");
                            $papi->setGroup($player, $s);
                            Server::getInstance()->broadcastMessage("§f[§c!§f]§r §fBravo à §4" . $player->getName() . "§f qui vient d'améloirer son rank à §dSaturne§f !");
                            $player->sendTitle("§c-§4 Bravo §c-");
                            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                            return true;
                        }
                        if($money == 10000){
                            EconomyAPI::getInstance()->reduceMoney($player, "10000");
                            $papi->setGroup($player, $s);
                            Server::getInstance()->broadcastMessage("§f[§c!§f]§r §fBravo à §4" . $player->getName() . "§f qui vient d'améloirer son rank à §dSaturne§f !");
                            $player->sendTitle("§c-§4 Bravo §c-");
                            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                            return true;
                        }
                        if($money < 10000){
                            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_FALL);
                            $player->sendMessage("§f[§c!§f]§r §cVous n'avez pas assez d'argent pour ameliorer votre rank!");
                            return true;
                        }
                    }
                    if($crank == "Saturne"){
                        if($money > 30000){
                            EconomyAPI::getInstance()->reduceMoney($player, "30000");
                            $papi->setGroup($player, $sp);
                            Server::getInstance()->broadcastMessage("§f[§c!§f]§r §fBravo à §4" . $player->getName() . "§f qui vient d'améloirer son rank à 
§5Saturne+§f !");
                            $player->sendTitle("§c-§4 Bravo §c-");
                            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                            return true;
                        }
                        if($money == 30000){
                            EconomyAPI::getInstance()->reduceMoney($player, "30000");
                            $papi->setGroup($player, $sp);
                            Server::getInstance()->broadcastMessage("§f[§c!§f]§r §fBravo à §4" . $player->getName() . "§f qui vient d'améloirer son rank à §5Saturne+§f !");
                            $player->sendTitle("§c-§4 Bravo §c-");
                            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                            return true;
                        }
                        if($money < 20000){
                            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_FALL);
                            $player->sendMessage("§f[§c!§f]§r §cVous n'avez pas assez d'argent pour ameliorer votre rank!");
                            return true;
                        }
                    }
                    if($crank == "Saturne-Plus"){
                        if($money > 50000){
                            EconomyAPI::getInstance()->reduceMoney($player, "50000");
                            $papi->setGroup($player, $e);
                            Server::getInstance()->broadcastMessage("§f[§c!§f]§r §fBravo à §4" . $player->getName() . "§f qui vient d'améloirer son rank à §9Eris§f !");
                            $player->sendTitle("§c-§4 Bravo §c-");
                            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                            return true;
                        }
                        if($money == 50000){
                            EconomyAPI::getInstance()->reduceMoney($player, "50000");
                            $papi->setGroup($player, $e);
                            Server::getInstance()->broadcastMessage("§f[§c!§f]§r §fBravo à §4" . $player->getName() . "§f qui vient d'améloirer son rank à §9Eris§f !");
                            $player->sendTitle("§c-§4 Bravo §c-");
                            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                            return true;
                        }
                        if($money < 50000){
                            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_FALL);
                            $player->sendMessage("§f[§c!§f]§r §cVous n'avez pas assez d'argent pour ameliorer votre rank!");
                            return true;
                        }
                    }
                    if($crank == "Eris"){
                        $player->sendMessage("§f§l[§3!§f]§r §fVous avez déjà le dernier rank !");
                        return true;
                    }
                break;

                case 1;

                break;
            }
        });
        $form->setTitle("§c- §fStats §c-");
        $form->setContent("§fVotre rank actuel est:§4 " . $crank . "\n§fVous avez: §4" . $money . "\n§fUn kill = §410\n§c» §fVoici les prix des ranks payants\n\n§fSaturne: §410000\n§fSaturne+:§4 30000\n§fEris:§4 50000\n\n§c» §fVous pouvez aussi en payer un depuis la boutique disponible sur le Discord : §bhttps://discord.gg/cGPvEmu");
        $form->addButton("Améliorer son rank\n§c(" . $crank . ")", 0);

        $form->sendToPlayer($player);
        return $form;
    }
}
