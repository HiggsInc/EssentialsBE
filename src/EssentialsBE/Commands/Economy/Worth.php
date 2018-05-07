<?php

declare(strict_types = 1);

namespace EssentialsBE\Commands\Economy;

use EssentialsBE\BaseFiles\BaseAPI;
use EssentialsBE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Worth extends BaseCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "worth", "Get the price of an item", "[item]", "<item>");
        $this->setPermission("essentials.worth");
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
        if(!isset($args[0])){
            $id = $sender->getInventory()->getItemInHand()->getId();
        }else{
            $id = $this->getAPI()->getItem($args[0])->getId();
        }
        if(!($worth = $this->getAPI()->getItemWorth($id))){
            $sender->sendMessage(TextFormat::RED . "[Error] §2Worth not available for this item");
            return false;
        }
        $sender->sendMessage(TextFormat::AQUA . "§aItem's worth is§b " . $this->getAPI()->getCurrencySymbol() . $worth);
        return true;
    }
}