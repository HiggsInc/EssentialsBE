<?php

declare(strict_types = 1);

namespace EssentialsBE\Commands;

use EssentialsBE\BaseFiles\BaseAPI;
use EssentialsBE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class Burn extends BaseCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "burn", "Set a player on fire", "<player> <seconds>");
        $this->setPermission("essentials.burn");
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
        if(count($args) !== 2){
            $this->sendUsage($sender, $alias);
            return false;
        }
        if(!($player = $this->getAPI()->getPlayer($args[0]))){
            $sender->sendMessage(TextFormat::RED . "[Error] §2Player not found");
            return false;
        }
        if(!is_numeric($time = $args[1])){
            $sender->sendMessage(TextFormat::RED . "[Error] §2Invalid burning time");
            return false;
        }
        $player->setOnFire($time);
        $sender->sendMessage(TextFormat::DARK_PURPLE . $player->getDisplayName() . " §dis now on fire!");
        return true;
    }
}
