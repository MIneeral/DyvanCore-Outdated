<?php

namespace Mineeral\Forms\Form;

use pocketmine\Player;

use pocketmine\utils\Config as C;

use Mineeral\Forms\FormAPI\CustomForm;
use Mineeral\Forms\FormAPI\ModalForm;
use Mineeral\Forms\FormAPI\SimpleForm;

use Mineeral\Main;
use Mineeral\Utils\Config;

use Mineeral\Constants\Prefix;
use Mineeral\Constants\Rank;


class AdminForm
{

    /**
     * @param Player $player
     * @return bool
     */
    public static function Ranks(Player $player) : bool
    {

        $array = array();

        foreach (Main::getInstance()->getServer()->getOnlinePlayers() as $p)
        {
            array_push($array, $p->getName());
        }

        $form = new CustomForm(function(Player $player, $data) use ($array){

            $result = $data;
    
            if($result == null){
    
                unset($array);
                return true;
    
            } else {

                $p = Main::getInstance()->getServer()->getPlayer($array[$result[0]]);
                $rank = Rank::RANK[$result[1]];
                $config = new C(Main::getInstance()->getDataFolder() . "/Infos/Rank.json", C::JSON);

                unset($array);
                Config::setConfig($p, $config, $rank);
                Main::getInstance()->getServer()->broadcastMessage(Prefix::IMPORTANT . $p->getName() . " vient de passer " . Rank::RANK_TEXT[$rank]);
                
                return true;
            }
    
        });

        $form->setTitle("§c- §7Rank§c -");
        $form->addDropdown("§cChoissisez le joueur", $array);
        $form->addDropdown("§cChoissisez le rank", Rank::RANK);
        $form->sendToPlayer($player);
        return true;

    }
}
