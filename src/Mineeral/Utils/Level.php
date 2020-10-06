<?php

namespace Mineeral\Utils;

use Mineeral\Main;
use Mineeral\Constants\Prefix;

class Level implements Prefix
{
    /**
     * @return string
     */
    public static function load()
    {

        $count = 0;

        foreach(scandir(Main::getInstance()->getServer()->getDataPath() . "/worlds/") as $world){

            if($world !== "." && $world !== ".." ){
                if(!(Main::getInstance()->getServer()->isLevelLoaded($world))){

                    $count = $count + 1;
                    Main::getInstance()->getServer()->loadLevel($world);

                }
            }
        }  

        return Prefix::CONSOLE . " " . $count . " Levels are loaded";

    }
}
