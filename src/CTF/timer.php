<?php

namespace CTF;

use pocketmine\scheduler\PluginTask;
use pocketmine\Server;

class timer extends PluginTask{
    public $times;
        public function getServer(){
            
            return Server::getInstance();
            
        }
	public function onRun($currentTick){           
            
            if ( $this->getOwner()->getConfig()->get("Game Length (Mins)") - $this->times > 0) {
                $this->broadcastScores();
                $times = $this->times + 1;
                $this->times = $times;
                $remaining = $this->getOwner()->getConfig()->get("Game Length (Mins)") - $this->times;
                $this->getServer()->broadcastMessage(round($remaining) . " min(s). remaining!" );
                $this->getServer()->broadcastMessage("Plugin made available by @EPICMC_US team!");
            }
            
            else {
                $this->endGame();
            }
	}
        
        public function broadcastScores(){
            
            $red = $this->getOwner()->temp["RedPoints"];
            $blue = $this->getOwner()->temp["BluePoints"];
            
            $this->getServer()->broadcastMessage("-==SCORE==-");
            $this->getServer()->broadcastMessage("Blue:" . $blue);
            $this->getServer()->broadcastMessage("Red:" . $red);
        }
        
        public function endGame() {
            
            if ($this->getOwner()->temp["BluePoints"] > $this->getOwner()->temp["RedPoints"]) {
                $this->broadcastScores();
                $this->getServer()->broadcastMessage("THE BLUE TEAM WINS!");
                $this->getServer()->broadcastMessage("Server will now restart");
                $this->getServer()->broadcastMessage("Please rejoin to play again!");
                sleep(3);
                $this->getServer()->shutdown();
            }
            else if ($this->getOwner()->temp["BluePoints"] < $this->getOwner()->temp["RedPoints"])
                {
                $this->broadcastScores();
                $this->getServer()->broadcastMessage("THE RED TEAM WINS!");
                $this->getServer()->broadcastMessage("Server will now restart");
                $this->getServer()->broadcastMessage("Please rejoin to play again!");
                sleep(3);
                $this->getServer()->shutdown();
            }
            else {
                $this->getServer()->broadcastMessage("The game ended in a tie!");
                $this->getServer()->broadcastMessage("Please rejoin to play again!");
                sleep(3);
                $this->getServer()->shutdown();
            
            }
        }
}