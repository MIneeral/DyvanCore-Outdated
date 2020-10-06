<?php

namespace Mineeral\Constants;

interface Rank
{

    public const RANK = 
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

    public const RANK_TEXT = 
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

    public const RANK_NAMETAG = 
    [
        "Player" => "§e[P]",
        "Saturne" => "§d[S]",
        "Saturne-Plus" => "§5[S+]",
        "Eris" => "§9[E]",
        "Guide" => "§a[G]",
        "Modo" => "§c[M]",
        "Super-Modo" => "§6[SM]",
        "Admin" => "§3[A]",
        "Owner" => "§4[O]"
    ];

    public const RANK_UP = 
    [
        "Player" => 
        [
            "rank" => "Saturne",
            "money" => 10000,
            "prefix" => "§dSaturne"
        ],

        "Saturne" => 
        [
            "rank" => "Saturne-Plus",
            "money" => 30000,
            "prefix" => "§5Saturne+"
        ],

        "Saturne-Plus" => 
        [
            "rank" => "Eris",
            "money" => 50000,
            "prefix" => "§9Eris"
        ],
    ];
}
