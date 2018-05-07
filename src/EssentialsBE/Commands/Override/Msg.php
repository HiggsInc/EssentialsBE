<?php

declare(strict_types = 1);

namespace EssentialsBE\Commands\Override;

use EssentialsBE\BaseFiles\BaseAPI;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\RemoteConsoleCommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Msg extends BaseOverrideCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "tell", "Send private messages to other players", "<player> <message ...>", true, ["msg", "m", "t", "whisper"]);
        $this->setPermission("essentials.msg");
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
        if(count($args) < 2){
            $this->sendUsage($sender, $alias);
            return false;
        }
        $t = array_shift($args);
        if(strtolower($t) !== "console" && strtolower($t) !== "rcon"){
            $t = $this->getAPI()->getPlayer($t);
            if(!$t){
                $sender->sendMessage(TextFormat::RED . "[Error] §2Player not found");
                return false;
            }
        }
        $sender->sendMessage(TextFormat::YELLOW . "§a[me -> §b" . ($t instanceof Player ? $t->getDisplayName() : $t) . "§a]" . TextFormat::LIGHT_PURPLE . " " . implode(" ", $args));
        $m = TextFormat::YELLOW . "§aMessage from:§b" . ($sender instanceof Player ? $sender->getDisplayName() : $sender->getName()) . " §a-> me]" . TextFormat::LIGHT_PURPLE . " " . implode(" ", $args);
        if($t instanceof Player){
            $t->sendMessage($m);
        }else{
            $this->getPlugin()->getLogger()->info($m);
        }
        $this->getAPI()->setQuickReply(($t instanceof Player ? $t : ($t === "console" ? new ConsoleCommandSender() : new RemoteConsoleCommandSender())), $sender);
        return true;
    }
}