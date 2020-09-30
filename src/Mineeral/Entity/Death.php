<?php

namespace Mineeral\Entity;

use pocketmine\entity\Monster;
use pocketmine\entity\EntityIds;

use Mineeral\Main;

class Death extends Monster
{

    const NETWORK_ID = EntityIds::CHICKEN;

    public $height = 0.7;
    public $width = 0.4;
    public $gravity = 0;

    public function getName() : string
    {

        return "Death";

    }

    public function initEntity() : void
    {

        parent::initEntity();
        $this->setImmobile(true);
        $this->setHealth($this->getHealth());
        $this->setNameTagAlwaysVisible(true);
        $this->setScale(0.001);

    }

    public function onUpdate(int $currentTick) : bool
    {   
        $alldeaths = array();

        $top = 1;
        $nametag = "§c- §fTop §410§f des personnes les plus mort(s) §c-\n";

        arsort($alldeaths);
        foreach($alldeaths as $name => $value){
            if($top > 10) break;
                $nametag .= "§4#{$top} §c{$name} §favec §c{$value} §fmort(s)\n";
                $top++;
        }

        $this->setNameTag($nametag);
        return parent::onUpdate($currentTick);

    }
}
