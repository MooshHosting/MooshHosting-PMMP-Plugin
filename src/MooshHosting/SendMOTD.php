<?php
namespace MooshHosting;
use pocketmine\network\mcpe\protocol\ToastRequestPacket;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TF;


class SendMOTD extends Task {

    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
        $this->preMessageLine = -1;
        $this->postMessageLine = -1;
        $this->getPreMessage = [
            "Hosted by:",
            "§bTo make your own server, check out:",
            "Powered by:",
            "§aFor cheap and affordable hosting, head over to:"
        ];
        $this->getPostMessage = [
            "§4Moosh§cHosting",
            "https://mooshhosting.com",
            "§4Moosh§cHosting",
            "https://mooshhosting.com"
        ];
    }

    public function onRun(): void{
            //Shuffle is off. 
            $this->preMessageLine++;
            $this->postMessageLine++;
            $preMessage = $this->getPreMessage[$this->preMessageLine];
            $postMessage = $this->getPostMessage[$this->postMessageLine];

            foreach ($this->plugin->getServer()->getOnlinePlayers() as $players) {
                if ($players instanceof Player){
                // $players->sendMessage($msg);
                $this->onToast($players, TF::YELLOW . $preMessage, $postMessage);
                }
            }
            if($this->preMessageLine === count($this->getPreMessage) - 1){
                $this->preMessageLine = -1;
            }
            if($this->postMessageLine === count($this->getPostMessage) - 1){
                $this->postMessageLine = -1;
            }
    }

    public function onToast(Player $player, string $title, string $body) : void {
        $player->getNetworkSession()->sendDataPacket(ToastRequestPacket::create($title, $body));
    }

    public function getPlugin(){
	   return $this->plugin;
    }
}