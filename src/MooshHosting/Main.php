<?php
namespace MooshHosting;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $minutes = "10";
        $this->getScheduler()->scheduleRepeatingTask(new SendMOTD($this), (20 * $minutes * 60));
        // $this->getScheduler()->scheduleRepeatingTask(new SendMOTD($this), 300); #Testing
    }
}