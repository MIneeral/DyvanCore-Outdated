<?php 

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Main;

use onebone\economyapi\EconomyAPI;

class Stats extends Command{

    public function __construct()
    {
        parent::__construct("stats", "Permet d'affiché tes stats");
        $this->setAliases(["st"]);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        $api = Main::getInstance()->getServer()->getPluginManager()->getPlugin("FormAPI");
        $perms = Main::getInstance()->getServer()->getPluginManager()->getPlugin("PurePerms");
        $crank = $perms->getUserDataMgr()->getGroup($sender)->getName();
        $money = EconomyAPI::getInstance()->myMoney($sender);

        $form = $api->createSimpleForm(function (Player $sender, int $data = null) use ($perms, $crank, $money){
            $result = $data;
            if($result === null){
                return true;
            }

            switch($result){
                case 0:
                    switch($crank) {
                        case "Player":
                            if($money >= 10000){

                                EconomyAPI::getInstance()->reduceMoney($sender, "10000");
                                $perms->setGroup($sender, $perms->getGroup("Saturne"));
                                Main::getInstance()->getServer()->broadcastMessage("§f[§c!§f]§r §fBravo à §4" . $sender->getName() . "§f qui vient d'améloirer son rank à §dSaturne§f !");
                                $sender->sendTitle("§c-§4 Bravo §c-");
                                $sender->getLevel()->broadcastLevelEvent($sender->add(0, $sender->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                                return true;
    
                            } else {
    
                                $sender->getLevel()->broadcastLevelEvent($sender->add(0, $sender->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_FALL);
                                $sender->sendMessage("§f[§c!§f]§r §cVous n'avez pas assez d'argent pour ameliorer votre rank!");
                                return true;
    
                            }
                        break;

                        case "Saturne":
                            if($money >= 30000){
                                EconomyAPI::getInstance()->reduceMoney($sender, "30000");
                                $perms->setGroup($sender, $perms->getGroup("Saturne-Plus"));
                                Main::getInstance()->getServer()->broadcastMessage("§f[§c!§f]§r §fBravo à §4" . $sender->getName() . "§f qui vient d'améloirer son rank à §5Saturne+§f !");
                                $sender->sendTitle("§c-§4 Bravo §c-");
                                $sender->getLevel()->broadcastLevelEvent($sender->add(0, $sender->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                                return true;
                            } else {
                                $sender->getLevel()->broadcastLevelEvent($sender->add(0, $sender->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_FALL);
                                $sender->sendMessage("§f[§c!§f]§r §cVous n'avez pas assez d'argent pour ameliorer votre rank!");
                                return true;
                            }
                        break;

                        case "Saturne-Plus":
                            if($money >= 50000){
                                EconomyAPI::getInstance()->reduceMoney($sender, "50000");
                                $perms->setGroup($sender, $perms->getGroup("Eris"));
                                Main::getInstance()->getServer()->broadcastMessage("§f[§c!§f]§r §fBravo à §4" . $sender->getName() . "§f qui vient d'améloirer son rank à §9Eris§f !");
                                $sender->sendTitle("§c-§4 Bravo §c-");
                                $sender->getLevel()->broadcastLevelEvent($sender->add(0, $sender->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                                return true;
                            } else {
                                $sender->getLevel()->broadcastLevelEvent($sender->add(0, $sender->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_FALL);
                                $sender->sendMessage("§f[§c!§f]§r §cVous n'avez pas assez d'argent pour ameliorer votre rank!");
                                return true;
                            }
                        break;

                        default:
                            $sender->sendMessage("§f§l[§3!§f]§r §fVous avez déjà un rank très haut !");
                            return true;
                        break;
                    }
                break;

                case 1;
                break;
            }
        });

        $form->setTitle("§c- §fStats §c-");
        $form->setContent("§fVotre rank actuel est:§4 " . $crank . "\n§fVous avez: §4" . $money . "\n§fUn kill = §410\n§c» §fVoici les prix des ranks payants\n\n§fSaturne: §410000\n§fSaturne+:§4 30000\n§fEris:§4 50000\n\n§c» §fVous pouvez aussi en payer un depuis la boutique disponible sur le Discord : §bhttps://discord.gg/cGPvEmu");
        $form->addButton("Améliorer son rank\n§c(" . $crank . ")", 0);
        $form->sendToPlayer($sender);

        return true;
    }
}
