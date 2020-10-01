<?php

namespace Mineeral\Forms\Form;

use pocketmine\Player;

use Mineeral\Forms\FormAPI\CustomForm;
use Mineeral\Forms\FormAPI\ModalForm;
use Mineeral\Forms\FormAPI\SimpleForm;

use  Mineeral\Main;

class AdminForm
{

    public const RANKS = 
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

    public const RANKS_TEXT = 
    [
        "Player" => "&e[Player]",
        "Saturne" => "&d[Saturne]",
        "Saturne-Plus" => "&5[Saturne+]",
        "Eris" => "&9[Eris]",
        "Guide" => "&a[Guide]",
        "Modo" => "&c[Modo]",
        "Super-Modo" => "&6[Super-Modo]",
        "Admin" => "&3[Admin]",
        "Owner" => "&4[Owner]"
    ];

    public static $list = array();

    public static function Ranks(Player $player) : bool
    {

        foreach (Main::getInstance()->getServer()->getOnlinePlayers() as $p)
        {
            array_push(AdminForm::$list, $p->getName());
        }

        $form = new CustomForm(function(Player $player, int $data = null){

            $result = $data;
    
            if($result == null){
    
                unset(AdminForm::$list);
                return true;
    
            } else {

                $p = Main::getInstance()->getServer()->getPlayer(AdminForm::$list[$result[0]]);
                
                unset(AdminForm::$list);
                Main::setConfig($player, "string", "rank", $result[1]);
                Main::getInstance()->getServer()->broadcastPopup(Main::getPrefix("important") . $p->getName() . " vien de passer " . AdminForm::RANKS_TEXT[$result[1]]);
    
            }
    
        });

        $form->setTitle("§4§lRank");
        $form->addDropdown("§bChoissisez le joueur", AdminForm::$list);
        $form->addDropdown("§bChoissisez le rank", AdminForm::RANKS);
        $form->sendToPlayer($player);
        return true;

    }
}