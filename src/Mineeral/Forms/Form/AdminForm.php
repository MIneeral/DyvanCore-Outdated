<?php

namespace Mineeral\Forms\Form;

use pocketmine\Player;

use pocketmine\utils\C;

use Mineeral\Forms\FormAPI\CustomForm;
use Mineeral\Forms\FormAPI\ModalForm;
use Mineeral\Forms\FormAPI\SimpleForm;

use Mineeral\Main;
use Mineeral\Utils\Config;
use Mineeral\Utils\Rank;

class AdminForm
{

    public static function Ranks(Player $player) : bool
    {

        $array = array();

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
                $rank = Rank::RANK[$result[1]];
                
                unset($array);
                $config = new C(Main::getInstance()->getDataFolder() . "/Infos/Rank.json", C::JSON);
                Config::setConfig($p, $config, $rank);
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
