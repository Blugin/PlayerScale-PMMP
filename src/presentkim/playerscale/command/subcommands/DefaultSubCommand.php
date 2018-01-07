<?php

namespace presentkim\playerscale\command\subcommands;

use pocketmine\command\CommandSender;
use presentkim\playerscale\{
  PlayerScaleMain as Plugin, util\Translation, command\SubCommand
};
use function presentkim\playerscale\util\toInt;

class DefaultSubCommand extends SubCommand{

    public function __construct(Plugin $owner){
        parent::__construct($owner, Translation::translate('prefix'), 'command-playerscale-default', 'playerscale.default.cmd');
    }

    /**
     * @param CommandSender $sender
     * @param array         $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args) : bool{
        if (isset($args[0])) {
            $default = toInt($args[0], null, function (int $i){
                return $i >= 0;
            });
            if ($default === null) {
                $sender->sendMessage($this->prefix . Translation::translate($this->getFullId('failure'), $args[0]));
            } else {
                $this->owner->getConfig()->set("default-scale", $default);
                $sender->sendMessage($this->prefix . Translation::translate($this->getFullId('success'), $default));
            }
            return true;
        }
        return false;
    }
}