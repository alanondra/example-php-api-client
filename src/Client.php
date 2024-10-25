<?php

declare(strict_types=1);

namespace AOndra\ExampleApi;

use Psr\Log\{
	LoggerAwareInterface,
	LoggerAwareTrait
};
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Client\ClientInterface;
use Psr\SimpleCache\CacheInterface;

class Client implements LoggerAwareInterface
{
	use LoggerAwareTrait;

	protected ?EventDispatcherInterface $events;
	protected ?CacheInterface $cache;

	public function __construct(
		protected ClientConfig $config,
		protected ClientInterface $http
	) {
		//
	}

	public function setEventDispatcher(?EventDispatcherInterface $events): void
	{
		$this->events = $events;
	}

	public function setCache(CacheInterface $cache): void
	{
		$this->cache = $cache;
	}
}
