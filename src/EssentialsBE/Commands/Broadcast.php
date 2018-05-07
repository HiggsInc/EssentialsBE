<?php

declare(strict_types = 1);

namespace EssentialsBE\Commands;

use EssentialsBE\BaseFiles\BaseAPI;
use EssentialsBE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class Broadcast extends BaseCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "broadcast", "Broadcast a message", "<message>", true, ["bcast"]);
        $this->setPermission("essentials.broadcast");
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
        if(count($args) < 1){
            $this->sendUsage($sender, $alias);
            return false;
        }
        $sender->getServer()->broadcastMessage(TextFormat::LIGHT_PURPLE . "§7[§aBroadcast§7] §b" . TextFormat::AQUA . implode(" ", $args));
        return true;
    }
}
