<?php

declare(strict_types = 1);

namespace EssentialsBE\Commands;

use EssentialsBE\BaseFiles\BaseAPI;
use EssentialsBE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Fly extends BaseCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "fly", "Fly in Survival or Adventure mode", "[player]");
        $this->setPermission("essentials.fly.use");
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
            if(!$sender->hasPermission("essentials.fly.other")){
                $sender->sendMessage(TextFormat::RED . $this->getPermissionMessage());
                return false;
            }elseif(!($player = $this->getAPI()->getPlayer($args[0]))){
                $sender->sendMessage(TextFormat::RED . "[Error] §2Player not found");
                return false;
            }
        }
        $this->getAPI()->switchCanFly($player);
        $player->sendMessage(TextFormat::YELLOW . "§dFlying mode " . ($this->getAPI()->canFly($player) ? "§5enabled" : "§3disabled") . "!");
        if($player !== $sender){
            $sender->sendMessage(TextFormat::YELLOW . "§bFlying mode " . ($this->getAPI()->canFly($player) ? "§5enabled" : "§3disabled") . " §dfor §5" . $player->getDisplayName());
        }
        return true;
    }
}