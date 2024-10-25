<?php

declare(strict_types=1);

namespace AOndra\ExampleApi;

use InvalidArgumentException;

class ClientConfig
{
	public string $scheme = 'https'
	{
		get => $this->scheme;

		set {
			$schemes = [
				'http',
				'https',
			];

			if (!in_array($value, $schemes)) {
				throw new InvalidArgumentException(sprintf(
					'Invalid scheme %s; must be one of: %s.',
					$value,
					implode(', ', $schemes)
				));
			}
		}
	}

	public string $domain = 'www.dummyjson.com'
	{
		get => $this->domain;

		set {
			$valid = filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);

			if (!$valid) {
				throw new InvalidArgumentException(sprintf(
					'Invalid hostname %s for %s.',
					$value,
					static::class
				));
			}

			$this->domain = $valid;
		}
	}

	public ?int $port = null
	{
		get => $this->port;

		set {
			if (is_null($value) || ($value >= 0 && $value < 65536)) {
				$this->port = $value;
			}

			throw new InvalidArgumentException(sprintf(
				'Invalid port number %d for %s.',
				$value,
				static::class
			));
		}
	}
}
