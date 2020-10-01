<?php

namespace Mineeral\Entity;

use pocketmine\entity\Monster;
use pocketmine\entity\EntityIds;

use Mineeral\Main;

class Kill extends Monster
{

    const NETWORK_ID = EntityIds::CHICKEN;

    public $height = 0.7;
    public $width = 0.4;
    public $gravity = 0;

    public function getName() : string
    {

        return "Kill";

    }

    public function initEntity() : void
    {

        parent::initEntity();
        $this->setImmobile();
        $this->setHealth($this->getHealth());
        $this->setNameTagAlwaysVisible(true);
        $this->setScale(0.001);

    }

    public function onUpdate(int $currentTick) : bool
    {

        $allkills = array();

        foreach(Main::onAllConfig() as $p) {

            $player = Main::getInstance()->getServer()->getPlayer($p);
            $allkills[$player->getName()] = $player->namedtag->kill;

        }

        $top = 1;
        $nametag = "§c- §fTop §410§f des personnes avec le plus de kill(s) §c-\n";

        arsort($allkills);
        foreach($allkills as $name => $value){
            if($top > 10) break;
                $nametag .= "§4#{$top} §c{$name} §favec §c{$value} §fkill(s)\n";
                $top++;
        }

        $this->setNameTag($nametag);
        return parent::onUpdate($currentTick);

    }
}
