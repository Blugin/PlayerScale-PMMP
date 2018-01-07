<?php

namespace presentkim\playerscale\command\subcommands;

use pocketmine\command\CommandSender;
use presentkim\playerscale\{
  PlayerScaleMain as Plugin, util\Translation, command\SubCommand
};
use function presentkim\playerscale\util\toInt;

class ListSubCommand extends SubCommand{

    public function __construct(Plugin $owner){
        parent::__construct($owner, Translation::translate('prefix'), 'command-playerscale-list', 'playerscale.list.cmd');
    }

    /**
     * @param CommandSender $sender
     * @param array         $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args) : bool{
        $list = [];
        $results = $this->owner->query("SELECT * FROM player_scale_list ORDER BY player_name ASC");
        while ($row = $results->fetchArray(SQLITE3_NUM)) {
            $list[] = $row;
        }
        $max = ceil(sizeof($list) / 5);
        $page = min($max, (isset($args[0]) ? toInt($args[0], 1, function (int $i){
              return $i > 0 ? 1 : -1;
          }) : 1) - 1);
        $message = Translation::translate($this->getFullId('head'), $page + 1, $max);
        for ($i = $page * 5; $i < ($page + 1) * 5 && $i < count($list); $i++) {
            $message .= PHP_EOL . Translation::translate($this->getFullId('item'), ...$list[$i]);
        }
        $sender->sendMessage("$this->prefix$message");

        return true;
    }
}