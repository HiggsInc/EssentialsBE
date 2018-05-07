<?php
namespace EssentialsBE\Commands\Teleport;

use EssentialsBE\BaseFiles\BaseAPI;
use EssentialsBE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class TPAll extends BaseCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "tpall", "Teleport all player to you or another player", "[player]");
        $this->setPermission("essentials.tpall");
    }

    /**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, $alias, array $args): bool{
        if(!$this->testPermission($sender)){
            return false;
        }
        if($this->getAPI()->getEssentialsBEPlugin()->getConfig()->get("teleporting") !== true) {
            $sender->sendMessage(TextFormat::RED . "This command has been disabled!");
            return false;
        }
        if((!isset($args[0]) && !$sender instanceof Player) || count($args) > 1){
            $this->sendUsage($sender, $alias);
            return false;
        }
        $player = $sender;
        if(isset($args[0]) && !($player = $this->getAPI()->getPlayer($args[0]))){
            $sender->sendMessage(TextFormat::RED . "[Error] Player not found");
            return false;
        }
        foreach($this->getAPI()->getServer()->getOnlinePlayers() as $p){
            if($p !== $player){
                $p->teleport($player);
                $p->sendMessage(TextFormat::YELLOW . "Teleporting to " . $player->getDisplayName() . "...");
            }
        }
        $player->sendMessage(TextFormat::YELLOW . "Teleporting players to you...");
        return true;
    }
} 