<?php

namespace presentkim\playerscale\command\subcommands;

namespace presentkim\playerscale\command;

use pocketmine\command\{
  Command, CommandExecutor, CommandSender
};
use presentkim\playerscale\PlayerScaleMain as Plugin;
use presentkim\playerscale\command\subcommands\{
  DefaultSubCommand, SetSubCommand, ListSubCommand, LangSubCommand, ReloadSubCommand, SaveSubCommand
};

class CommandListener implements CommandExecutor{

    /** @var Plugin */
    protected $owner;

    /**
     * SubComamnd[] $subcommands
     */
    protected $subcommands = [];

    /** @param Plugin $owner */
    public function __construct(Plugin $owner){
        $this->owner = $owner;

        $this->subcommands = [
          new DefaultSubCommand($this->owner),
          new SetSubCommand($this->owner),
          new ListSubCommand($this->owner),
          new LangSubCommand($this->owner),
          new ReloadSubCommand($this->owner),
          new SaveSubCommand($this->owner),
        ];
    }

    /**
     * @param CommandSender $sender
     * @param Command       $command
     * @param string        $label
     * @param string[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if (!isset($args[0])) {
            return false;
        } else {
            $label = array_shift($args);
            foreach ($this->subcommands as $key => $value) {
                if ($value->checkLabel($label)) {
                    $value->execute($sender, $args);
                    return true;
                }
            }
            return false;
        }
    }
}