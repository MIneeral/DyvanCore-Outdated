<?php

namespace Mineeral\Forms\Form;

use pocketmine\Player;

use pocketmine\utils\Config;

use Mineeral\Forms\FormAPI\CustomForm;
use Mineeral\Forms\FormAPI\ModalForm;
use Mineeral\Forms\FormAPI\SimpleForm;

use  Mineeral\Main;

class AdminForm
{

    public static function Ranks(Player $player) : bool
    {

        $array = array();

        $ranks = 
        [
            "Player",
            "Saturne",
            "Saturne-Plus",
            "Eris",
            "Guide",
            "Modo",
            "Super-Modo",
            "Admin",
            "Owner"
        ];

        $ranks_text = 
        [
            "Player" => "§e[Player]",
            "Saturne" => "§d[Saturne]",
            "Saturne-Plus" => "§5[Saturne+]",
            "Eris" => "§9[Eris]",
            "Guide" => "§a[Guide]",
            "Modo" => "§c[Modo]",
            "Super-Modo" => "§6[Super-Modo]",
            "Admin" => "§3[Admin]",
            "Owner" => "§4[Owner]"
        ];

        foreach (Main::getInstance()->getServer()->getOnlinePlayers() as $p)
        {
            array_push($array, $p->getName());
        }

        $form = new CustomForm(function(Player $player, $data) use ($array, $ranks, $ranks_text){

            $result = $data;
    
            if($result == null){
    
                unset($array);
                return true;
    
            } else {

                $p = Main::getInstance()->getServer()->getPlayer($array[$result[0]]);
                $rank = $ranks[$result[1]];
                
                unset($array);
                $config = new Config(Main::getInstance()->getDataFolder() . "/Infos/Rank.json", Config::JSON);
                Main::setConfig($p, $config, $rank);
                Main::getInstance()->getServer()->broadcastMessage(Main::PREFIX_IMPORTANT . $p->getName() . " vient de passer " . $ranks_text[$rank]);
    
            }
    
        });

        $form->setTitle("§c- §7Rank§c -");
        $form->addDropdown("§cChoissisez le joueur", $array);
        $form->addDropdown("§cChoissisez le rank", $ranks);
        $form->sendToPlayer($player);
        return true;

    }
}
