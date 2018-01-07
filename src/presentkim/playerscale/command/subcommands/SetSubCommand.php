<?php

namespace presentkim\playerscale\command\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\Server;
use presentkim\playerscale\{
  PlayerScaleMain as Plugin, util\Translation, command\SubCommand
};
use function presentkim\playerscale\util\toInt;
use function strtolower;

class SetSubCommand extends SubCommand{

    public function __construct(Plugin $owner){
        parent::__construct($owner, Translation::translate('prefix'), 'command-playerscale-set', 'playerscale.set.cmd');
    }

    /**
     * @param CommandSender $sender
     * @param array         $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args) : bool{
        if (isset($args[1])) {
            $playerName = strtolower($args[0]);
            $player = Server::getInstance()->getPlayerExact($playerName);
            $result = $this->owner->query("SELECT player_scale FROM player_scale_list WHERE player_name = \"$playerName\";")->fetchArray(SQLITE3_NUM)[0];
            if ($player === null && $result === null) {
                $sender->sendMessage($this->prefix . Translation::translate($this->getFullId('failure-undefined-player'), $args[0]));
            } else {
                $scale = toInt($args[1], null, function (int $i){
                    return $i > 0;
                });
                if ($scale === null) {
                    $sender->sendMessage($this->prefix . Translation::translate($this->getFullId('failure-limit'), $args[1]));
                } else {
                    if ($scale == ((int) $this->owner->getConfig()->get("default-scale"))) { // Are you set to default scale? I will remove data
                        if ($result === null) { // When first query result is not exists
                            $sender->sendMessage($this->prefix . Translation::translate($this->getFullId('failure-default'), $args[0]));
                        } else {
                            $this->owner->query("DELETE FROM player_scale_list WHERE player_name = '$playerName'");
                            $sender->sendMessage($this->prefix . Translation::translate($this->getFullId('success-default'), $playerName));
                        }
                    } else {
                        if ($result === null) { // When first query result is not exists
                            $this->owner->query("INSERT INTO player_scale_list VALUES (\"$playerName\", $scale);");
                        } else {
                            $this->owner->query("
                                UPDATE player_scale_list
                                    set player_scale = $scale
                                WHERE player_name = \"$playerName\";
                            ");
                        }
                        $sender->sendMessage($this->prefix . Translation::translate($this->getFullId('success-set'), $playerName, $scale));
                    }
                    if (!$player == null) {
                        $this->owner->applyTo($player);
                    }
                }
            }
            return true;
        }
        return false;
    }
}