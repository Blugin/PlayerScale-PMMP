<?php

namespace presentkim\playerscale\command\subcommands;

use pocketmine\{
  Server, command\CommandSender
};
use presentkim\playerscale\{
  command\PoolCommand, PlayerScaleMain as Plugin, util\Translation, command\SubCommand, util\Utils
};

class SetSubCommand extends SubCommand{

    public function __construct(PoolCommand $owner){
        parent::__construct($owner, 'set');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args) : bool{
        if (isset($args[1])) {
            $playerName = strtolower($args[0]);
            $player = Server::getInstance()->getPlayerExact($playerName);
            $configData = $this->plugin->getConfig()->getAll();
            $playerData = $configData['playerData'];
            $exists = isset($playerData[$playerName]);
            if ($player === null && !$exists) {
                $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid-player', $args[0]));
            } else {
                $scale = Utils::toInt($args[1], null, function (int $i){
                    return $i > 0;
                });
                if ($scale === null) {
                    $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[1]));
                } else {
                    if ($scale == ((int) $this->plugin->getConfig()->get("default-scale"))) { // Are you set to default scale? I will remove dataif ($speed == ((int) $configData['default-speed'])) {
                        if ($exists) {
                            unset($playerData[$playerName]);
                            $this->plugin->getConfig()->set('playerData', $playerData);
                            $sender->sendMessage(Plugin::$prefix . $this->translate('success-default', $playerName));

                        } else {
                            $sender->sendMessage(Plugin::$prefix . $this->translate('failure-default', $playerName));
                        }
                    } else {
                        $playerData[$playerName] = $scale;
                        $this->plugin->getConfig()->set('playerData', $playerData);
                        $sender->sendMessage(Plugin::$prefix . $this->translate('success-set', $playerName, $scale));
                    }
                    if (!$player == null) {
                        $this->plugin->applyTo($player);
                    }
                }
            }
            return true;
        }
        return false;
    }
}