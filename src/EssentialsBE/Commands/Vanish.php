<?php

declare(strict_types = 1);

namespace EssentialsBE\Commands;

use EssentialsBE\BaseFiles\BaseAPI;
use EssentialsBE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Vanish extends BaseCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "vanish", "Hide from other players", "[player]", true, ["v"]);
        $this->setPermission("essentials.vanish.use");
    }

    /**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $alias, array $args): bool{
        if(!$this->testPermission($sender)){
            return false;
        }
        if((!isset($args[0]) && !$sender instanceof Player) || count($args) > 1){
            $this->sendUsage($sender, $alias);
            return false;
        }
        $player = $sender;
        if(isset($args[0])){
            if(!$sender->hasPermission("essentials.vanish.other")){
                $sender->sendMessage($this->getPermissionMessage());
                return false;
            }elseif(!($player = $this->getAPI()->getPlayer($args[0]))){
                $sender->sendMessage(TextFormat::RED . "[Error] §2Player not found");
                return false;
            }
        }
        $this->getAPI()->switchVanish($player);
        $player->sendMessage(TextFormat::GRAY . "§dYou're now " . ($s = $this->getAPI()->isVanished($player) ? "§5vanished" : "§3visible"));
        if($player !== $sender){
            $sender->sendMessage(TextFormat::DARK_PURPLE .  $player->getDisplayName() . " §dis now $s");
        }
        return true;
    }
}
