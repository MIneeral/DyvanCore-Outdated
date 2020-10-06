<?php

namespace Mineeral\Constants;

interface Prefix 
{

    public const DEFAULT = "§f[§c!§f] ";
    public const CONSOLE = "§f[§cDyn§f]§a ";
    public const IMPORTANT = Prefix::DEFAULT . "§f";
    public const GOOD = Prefix::DEFAULT . "§a";
    public const BAD = Prefix::DEFAULT . "§c";

}

