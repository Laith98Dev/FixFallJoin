<?php

namespace Laith98Dev\FixFallJoin;

/*  
 *  A plugin for PocketMine-MP for fix glitch fall join.
 *	
 *  Plugin By:                                                                           
 *	 _           _ _   _    ___   ___  _____             
 *	| |         (_) | | |  / _ \ / _ \|  __ \            
 *	| |     __ _ _| |_| |_| (_) | (_) | |  | | _____   __
 *	| |    / _` | | __| '_ \__, |> _ <| |  | |/ _ \ \ / /
 *	| |___| (_| | | |_| | | |/ /| (_) | |__| |  __/\ V / 
 *	|______\__,_|_|\__|_| |_/_/  \___/|_____/ \___| \_/  
 *		
 *	Youtube: Laith Youtuber
 *	Facebook: Laith A Al Haddad
 *	Discord: Laith.97#0695
 *	Gihhub: Laith98Dev
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 	
 */

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\Player;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerMoveEvent;

class Main extends PluginBase implements Listener
{
	/** @var array */
	public $login = [];
	
	/** @var array */
	public $join = [];
	
	/** @var array */
	public $move = [];
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onLogin(PlayerLoginEvent $event): void{
		$player = $event->getPlayer();
		
		if(!$player instanceof Player) return;
		
		$this->login[$player->getName()] = 1;
	}
	
	public function onJoin(PlayerJoinEvent $event): void{
		$player = $event->getPlayer();
		
		if(!$player instanceof Player) return;
		
		if(isset($this->login[$player->getName()])){
			unset($this->login[$player->getName()]);
			$this->join[$player->getName()] = 1;
		}
	}
	
	public function onMove(PlayerMoveEvent $event): void{
		$player = $event->getPlayer();
		
		if(!$player instanceof Player) return;
		
		if(isset($this->login[$player->getName()]) || isset($this->move[$player->getName()])){
			$event->setCancelled();
		}
		
		if(isset($this->join[$player->getName()])){
			unset($this->join[$player->getName()]);
			$this->move[$player->getName()] = 1;
			return;
		}
		
		if(isset($this->move[$player->getName()])){
			unset($this->move[$player->getName()]);
		}
	}
}
