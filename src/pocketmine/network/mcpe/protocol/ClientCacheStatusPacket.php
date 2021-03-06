<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

use pocketmine\utils\Binary;

use pocketmine\network\mcpe\NetworkSession;

class ClientCacheStatusPacket extends DataPacket/* implements ServerboundPacket*/{
	public const NETWORK_ID = ProtocolInfo::CLIENT_CACHE_STATUS_PACKET;

	/** @var bool */
	private $enabled;

	public static function create(bool $enabled) : self{
		$result = new self;
		$result->enabled = $enabled;
		return $result;
	}

	/**
	 * @return bool
	 */
	public function isEnabled() : bool{
		return $this->enabled;
	}

	protected function decodePayload() : void{
		$this->enabled = (($this->get(1) !== "\x00"));
	}

	protected function encodePayload() : void{
		($this->buffer .= ($this->enabled ? "\x01" : "\x00"));
	}

	public function handle(NetworkSession $handler) : bool{
		return $handler->handleClientCacheStatus($this);
	}
}
