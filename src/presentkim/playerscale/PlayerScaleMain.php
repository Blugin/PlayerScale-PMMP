<?php

namespace presentkim\playerscale;

use pocketmine\command\{
  CommandExecutor, PluginCommand
};
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use presentkim\playerscale\{
  listener\PlayerEventListener, command\CommandListener, util\Translation
};
use function presentkim\playerscale\util\extensionLoad;

class PlayerScaleMain extends PluginBase{

    /** @var self */
    private static $instance = null;

    /** @var \Sqlite3 */
    private $db;

    /** @var PluginCommand[] */
    private $commands = [];

    /** @return self */
    public static function getInstance(){
        return self::$instance;
    }

    public function onLoad(){
        if (self::$instance === null) {
            // register instance
            self::$instance = $this;

            // load utils
            $this->getServer()->getLoader()->loadClass('presentkim\playerscale\util\Utils');
        }

        // init data.sqlite3
        extensionLoad('sqlite3');
        $dataFolder = $this->getDataFolder();
        if (!file_exists($dataFolder)) {
            mkdir($dataFolder, 0777, true);
        }
        $this->db = new \SQLITE3($dataFolder . 'data.sqlite3');
    }

    public function onEnable(){
        $this->load();

        // register event listeners
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEventListener(), $this);
    }

    public function onDisable(){
        $this->save();
    }

    /**
     * @param string $query
     *
     * @return \SQLite3Result
     */
    public function query(string $query){
        return $this->db->query($query);
    }

    public function load(){
        $dataFolder = $this->getDataFolder();
        if (!file_exists($dataFolder)) {
            mkdir($dataFolder, 0777, true);
        }

        // load db
        $this->query("
            CREATE TABLE IF NOT EXISTS player_scale_list (
                player_name  TEXT NOT NULL,
                player_scale INT  NOT NULL CHECK(player_scale > 0),
                PRIMARY KEY (player_name)
            );
            COMMIT;
        ");
        $this->saveDefaultConfig();
        $this->reloadConfig();

        // load lang
        $langfilename = $dataFolder . 'lang.yml';
        if (!file_exists($langfilename)) {
            Translation::loadFromResource($this->getResource('lang/eng.yml'));
            Translation::save($langfilename);
        } else {
            Translation::load($langfilename);
        }

        // unregister commands
        foreach ($this->commands as $command) {
            $this->getServer()->getCommandMap()->unregister($command);
        }
        $this->commands = [];

        // register commands
        $this->registerCommand(new CommandListener($this), Translation::translate('command-playerscale'), 'PlayerScale', 'playerscale.cmd', Translation::translate('command-playerscale@description'), Translation::translate('command-playerscale@usage'), Translation::getArray('command-playerscale@aliases'));
    }

    public function save(){
        $dataFolder = $this->getDataFolder();
        if (!file_exists($dataFolder)) {
            mkdir($dataFolder, 0777, true);
        }

        // save db
        $this->saveConfig();

        // save lang
        $langfilename = $dataFolder . 'lang.yml';
        if (!file_exists($langfilename)) {
            Translation::loadFromResource($this->getResource('lang/eng.yml'));
            Translation::save($langfilename);
        } else {
            Translation::load($langfilename);
        }
    }

    /**
     * @param CommandExecutor $executor
     * @param                 $name
     * @param                 $fallback
     * @param                 $permission
     * @param string          $description
     * @param null            $usageMessage
     * @param array|null      $aliases
     */
    private function registerCommand(CommandExecutor $executor, $name, $fallback, $permission, $description = "", $usageMessage = null, array $aliases = null){
        $command = new PluginCommand($name, $this);
        $command->setExecutor($executor);
        $command->setPermission($permission);
        $command->setDescription($description);
        $command->setUsage($usageMessage ?? ('/' . $name));
        if (is_array($aliases)) {
            $command->setAliases($aliases);
        }

        $this->getServer()->getCommandMap()->register($fallback, $command);
        $this->commands[] = $command;
    }

    /**
     * @param Player $player
     */
    public function applyTo(Player $player){
        $result = $this->query('SELECT player_scale FROM player_scale_list WHERE player_name = "' . strtolower($player->getName()) . '";')->fetchArray(SQLITE3_NUM)[0];
        if ($result !== null) { // When query result is exists
            $scale = ((int) $result) * 0.01;
        } else {
            $scale = ((int) $this->getConfig()->get("default-scale")) * 0.01;
        }
        $player->setScale($scale);
    }
}