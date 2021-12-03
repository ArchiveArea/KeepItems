<?php

declare(strict_types=1);

namespace NhanAZ\KeepInventory;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerDeathEvent;

class Main extends PluginBase implements Listener
{

	protected function onEnable() : void
	{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
		$notices = $this->getConfig()->get("Notices");
		$keepInventory = $this->getConfig()->get("KeepInventory");
		if ($notices == true) {
			if ($keepInventory == true) {
				$this->getLogger()->notice("Items in the player's inventory that will be kept after they die are enabled. Edit `KeepInventory: true` to `KeepInventory: false` in `config.yml` to disable");
			} else {
				$this->getLogger()->notice("Items in the player's inventory that will not be kept after they die are enabled. Edit `KeepInventory: false` to `KeepInventory: true` in `config.yml` to enable");
			}
		} else {
			$this->getLogger()->warning("The notifications related to this plugin are being disabled! Edit `Notices: true` in `config.yml` to enable!");
		}
	}

	public function PlayerDeath(PlayerDeathEvent $event)
	{
		$player = $event->getPlayer();
		$keepInventory = $this->getConfig()->get("KeepInventory");
		$messageAfterDeath = $this->getConfig()->get("MessageAfterDeath");
		$messageToPlayerAfterDeath = $this->getConfig()->get("MessageToPlayerAfterDeath");
		$messageType = $this->getConfig()->get("MessageType");
		if ($keepInventory == true) {
			$event->setKeepInventory(true);
			if ($messageAfterDeath == true) {
				if ($messageType == "message") {
					$player->sendMessage($messageToPlayerAfterDeath);
				}
				if ($messageType == "title") {
					$player->sendTitle($messageToPlayerAfterDeath);
				}
				if ($messageType == "popup") {
					$player->sendPopup($messageToPlayerAfterDeath);
				}
				if ($messageType == "tip") {
					$player->sendTip($messageToPlayerAfterDeath);
				}
				if ($messageType == "actionbarmessage") {
					$player->sendActionBarMessage($messageToPlayerAfterDeath);
				}
			}
		} else {
			$event->setKeepInventory(false);
		}
	}

}
