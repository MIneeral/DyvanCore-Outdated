<?php 

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\Command as Cmd;
use pocketmine\command\CommandSender;

use Mineeral\Main;

use Mineeral\Constants\Form;

use Mineeral\Forms\Form\PlayerForm;

class Kits extends Cmd{

    public function __construct()
    {

        parent::__construct("kit", "Permet d'affiché les kits");

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) PlayerForm::Kits($sender);
        else $sender->sendMessage(Form::ONLY_GAME);
        
        return true;

    }
}
