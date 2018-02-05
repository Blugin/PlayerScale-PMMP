<?php

namespace presentkim\playerscale\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use presentkim\playerscale\PlayerScale as Plugin;

class PlayerEventListener implements Listener{

    /** @var Plugin */
    private $owner = null;

    public function __construct(){
        $this->owner = Plugin::getInstance();
    }

    /** @param PlayerJoinEvent $event */
    public function onPlayerJoinEvent(PlayerJoinEvent $event){
        $this->owner->applyTo($event->getPlayer());
    }
}