<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 2/10/2017
 * Time: 9:48 PM
 */

namespace sys\arenapvp;


use pocketmine\entity\Arrow;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerKickEvent;
use pocketmine\event\player\PlayerQuitEvent;
use sys\arenapvp\basefiles\BaseListener;
use sys\arenapvp\match\Match;


class MatchListener extends BaseListener {


	public function __construct(ArenaPvP $plugin) {
		parent::__construct($plugin);
	}

	public function onHit(ProjectileHitEvent $event): void {
		$entity = $event->getEntity();
		$player = $entity->getOwningEntity();
		if ($player instanceof ArenaPlayer) {
			if ($player instanceof ArenaPlayer and $player->inMatch() and $entity instanceof Arrow) {
				if ($entity->hadCollision) {
					$entity->close();
				}
			}
		}
	}

	public function onCraft(CraftItemEvent $event): void {
		$player = $event->getPlayer();
		if ($player instanceof ArenaPlayer and $player->getMatch() instanceof Match) {
			$event->setCancelled();
		}
	}

	public function onInteract(PlayerInteractEvent $event): void {
		$player = $event->getPlayer();
		if ($player instanceof ArenaPlayer and $player->inMatch()) {
			$player->getMatch()->onInteract($event);
		}
	}

	public function onBreak(BlockBreakEvent $event) {
		$player = $event->getPlayer();
		if ($player instanceof ArenaPlayer and $player->inMatch()) {
			$player->getMatch()->onBreak($event);
		}
	}

	public function onPlace(BlockPlaceEvent $event): void {
		$player = $event->getPlayer();
		if ($player instanceof ArenaPlayer and $player->inMatch()) {
			$player->getMatch()->onPlace($event);
		}
	}

	public function onRegainHealth(EntityRegainHealthEvent $event): void {
		$player = $event->getEntity();
		if ($player instanceof ArenaPlayer and $player->inMatch()) {
			$player->getMatch()->onRegainHealth($event);
		}
	}


	public function onDamage(EntityDamageEvent $event): void {
		$player = $event->getEntity();
		if ($player instanceof ArenaPlayer and $player->inMatch()) {
			$player->getMatch()->onDamage($event);
		}
	}

	public function onQuit(PlayerQuitEvent $event): void {
		$player = $event->getPlayer();
		if ($player instanceof ArenaPlayer and $player->inMatch()) {
			$player->getMatch()->onLeave($event);
		}
	}

	public function onKick(PlayerKickEvent $event): void {
		$player = $event->getPlayer();
		if ($player instanceof ArenaPlayer and $player->inMatch()) {
			$player->getMatch()->onLeave($event);
		}
	}


}