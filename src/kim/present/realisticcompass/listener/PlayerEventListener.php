<?php

/*
 *
 *  ____                           _   _  ___
 * |  _ \ _ __ ___  ___  ___ _ __ | |_| |/ (_)_ __ ___
 * | |_) | '__/ _ \/ __|/ _ \ '_ \| __| ' /| | '_ ` _ \
 * |  __/| | |  __/\__ \  __/ | | | |_| . \| | | | | | |
 * |_|   |_|  \___||___/\___|_| |_|\__|_|\_\_|_| |_| |_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author  PresentKim (debe3721@gmail.com)
 * @link    https://github.com/PresentKim
 * @license https://www.gnu.org/licenses/agpl-3.0.html AGPL-3.0.0
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 */

declare(strict_types=1);

namespace kim\present\realisticcompass\listener;

use kim\present\realisticcompass\RealisticCompass;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;

class PlayerEventListener implements Listener{
	/** @var RealisticCompass */
	private $plugin;

	/**
	 * PlayerEventListener constructor.
	 *
	 * @param RealisticCompass $plugin
	 */
	public function __construct(RealisticCompass $plugin){
		$this->plugin = $plugin;
	}

	/**
	 * @priority MONITOR
	 *
	 * @param PlayerItemHeldEvent $event
	 */
	public function onPlayerItemHeldEvent(PlayerItemHeldEvent $event) : void{
		if(!$event->isCancelled()){
			$player = $event->getPlayer();
			if($this->plugin->isRealsticCompass($event->getItem())){
				$this->plugin->getTask()->addPlayer($player);
			}else{
				$this->plugin->getTask()->removePlayer($player);
				RealisticCompass::sendReal($player);
			}
		}
	}

	/**
	 * @priority MONITOR
	 *
	 * @param PlayerInteractEvent $event
	 */
	public function onPlayerInteractEvent(PlayerInteractEvent $event) : void{
		if($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR){
			$player = $event->getPlayer();
			if($this->plugin->isRealsticCompass($player->getInventory()->getItemInHand())){
				$player->sendPosition($player, 180.0, $player->pitch);
			}
		}
	}
}