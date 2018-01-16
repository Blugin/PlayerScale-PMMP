<?php

namespace presentkim\playerscale\command\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\Server;
use presentkim\playerscale\{
  command\PoolCommand, PlayerScaleMain as Plugin, command\SubCommand
};
use function presentkim\playerscale\util\toInt;

class ListSubCommand extends SubCommand{

    public function __construct(PoolCommand $owner){
        parent::__construct($owner, 'list');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args){
        $list = [];
        foreach ($this->plugin->getConfig()->get('playerData') as $key => $value) {
            if (($player = Server::getInstance()->getPlayerExact($key)) !== null) {
                $key = $player->getName();
            }
            $list[] = [$key, $value];
        }

        $max = ceil(sizeof($list) / 5);
        $page = min($max, (isset($args[0]) ? toInt($args[0], 1, function (int $i){
              return $i > 0 ? 1 : -1;
          }) : 1) - 1);
        $sender->sendMessage(Plugin::$prefix . $this->translate('head', $page + 1, $max));
        for ($i = $page * 5; $i < ($page + 1) * 5 && $i < count($list); $i++) {
            $sender->sendMessage($this->translate('item', ...$list[$i]));
        }

        return true;
    }
}