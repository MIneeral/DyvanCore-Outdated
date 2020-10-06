<?php

namespace Mineeral\Constants;

interface Prefix 
{

    public const DEFAULT = "§f[§c!§f] ";
    public const CONSOLE = "§f[§cDyn§f]§a ";
    public const IMPORTANT = Message::DEFAULT . "§f";
    public const GOOD = Message::DEFAULT . "§a";
    public const BAD = Message::DEFAULT . "§c";

}

