<?php

namespace Mineeral\Utils;

use pocketmine\entity\Entity as E;

use Mineeral\Main;
use Mineeral\Constants\Prefix;

use Mineeral\Entity\Kill;
use Mineeral\Entity\Death;

class Entity implements Prefix
{

    public static function load()
    {

        $entity = 
        [
            //Entity LearderBoard
            Kill::class,
            Death::class,
        ];

        $count = 0;

        foreach($entity as $e) {

            $count = $count + 1;
            E::registerEntity($e, true);

        }

        return Prefix::CONSOLE . " " . $count . " Entity are loaded";

    }
}
