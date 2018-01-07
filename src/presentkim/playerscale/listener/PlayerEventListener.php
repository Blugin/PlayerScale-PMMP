<?php

namespace presentkim\playerscale\listener;

use pocketmine\event\{
  Listener, player\PlayerJoinEvent, player\PlayerMoveEvent, player\PlayerRespawnEvent
};
use presentkim\playerscale\PlayerScaleMain as Plugin;

class PlayerEventListener implements Listener{

    /** @var Plugin */
    private $owner = null;

    public function __construct(){
        $this->owner = Plugin::getInstance();
    }

    /** @param PlayerJoinEvent $event */
    public function onPlayerJoinEvent(PlayerJoinEvent $event) : void{
        $this->owner->applyTo($event->getPlayer());
    }
}