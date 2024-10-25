<?php

declare(strict_types=1);

namespace AOndra\ExampleApi\Requests;

use InvalidArgumentException;
use Psr\Http\Message\{
	RequestFactoryInterface,
	RequestInterface,
	StreamFactoryInterface,
	StreamInterface,
	UriFactoryInterface,
	UriInterface,
};
use AOndra\ExampleApi\Requests\Contracts\RequestBuilderInterface;

class AbstractRequestBuilder implements RequestBuilderInterface
{
	protected RequestFactoryInterface $requestFactory;

	protected StreamFactoryInterface $streamFactory;

	protected UriFactoryInterface $uriFactory;

	protected ?string $protocolVersion = null;

	protected string $scheme = 'https';

	protected ?string $host = null;

	protected ?int $port = null;

	/**
	 * @inheritDoc
	 *
	 * @param \Psr\Http\Message\RequestFactoryInterface $requestFactory
	 *
	 * @return void
	 */
	public function setRequestFactory(RequestFactoryInterface $requestFactory): void
	{
		$this->requestFactory = $requestFactory;
	}

	/**
	 * @inheritDoc
	 *
	 * @param \Psr\Http\Message\StreamFactoryInterface $streamFactory
	 *
	 * @return void
	 */
	public function setStreamFactory(StreamFactoryInterface $streamFactory): void
	{
		$this->streamFactory = $streamFactory;
	}

	/**
	 * @inheritDoc
	 *
	 * @param \Psr\Http\Message\UriFactoryInterface $uriFactory
	 *
	 * @return void
	 */
	public function setUriFactory(UriFactoryInterface $uriFactory): void
	{
		$this->uriFactory = $uriFactory;
	}

	/**
	 * Return an instance with the specified HTTP protocol version.
	 *
	 * @param string $protocolVersion The HTTP protocol version to use (e.g., '1.0', '1.1', '2', '2.0', '3').
	 *
	 * @return static A new instance with the specified protocol version.
	 *
	 * @throws \InvalidArgumentException If the protocol version is invalid.
	 */
	public function withProtocolVersion(string $protocolVersion): static
	{
		$allowedVersions = ['1.0', '1.1', '2', '2.0', '3', '3.0'];

		if (!in_array($protocolVersion, $allowedVersions, true)) {
			throw new InvalidArgumentException(sprintf(
				'Invalid protocol version "%s" provided to %s. Allowed versions are: %s.',
				$protocolVersion,
				static::class,
				implode(', ', $allowedVersions)
			));
		}

		$copy = clone $this;
		$copy->protocolVersion = $protocolVersion;
		return $copy;
	}

	/**
	 * Return an instance with the specified URI scheme.
	 *
	 * @param string $scheme The URI scheme to use (e.g., 'http', 'https').
	 *
	 * @return static A new instance with the specified scheme.
	 *
	 * @throws \InvalidArgumentException If the scheme is invalid.
	 */
	public function withScheme(string $scheme): static
	{
		$schemes = [
			'http',
			'https',
		];

		if (!in_array($scheme, $schemes)) {
			throw new InvalidArgumentException(sprintf(
				'Invalid scheme %s; must be one of: %s.',
				$scheme,
				implode(', ', $schemes)
			));
		}

		$copy = clone $this;
		$copy->scheme = $scheme;
		return $copy;
	}

	/**
	 * Return an instance with the specified host.
	 *
	 * @param string $host The hostname to use.
	 *
	 * @return static A new instance with the specified host.
	 *
	 * @throws \InvalidArgumentException If the host is invalid.
	 */
	public function withHost(string $host): static
	{
		if (!filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
			throw new InvalidArgumentException(sprintf(
				'Invalid hostname %s for %s.',
				$host,
				static::class
			));
		}

		$copy = clone $this;
		$copy->host = $host;
		return $copy;
	}

	/**
	 * Return an instance with the specified port.
	 *
	 * @param int $port The port number to use.
	 *
	 * @return static A new instance with the specified port.
	 *
	 * @throws \InvalidArgumentException If the port is not between 1 and 65535.
	 */
	public function withPort(int $port): static
	{
		$min = 0;
		$max = 65535;

		if ($port < $min || $port > $max) {
			throw new InvalidArgumentException(sprintf(
				'Invalid port "%d" provided to %s. Port must be between %d and %d.',
				$port,
				static::class,
				$min,
				$max
			));
		}

		$copy = clone $this;
		$copy->port = $port;
		return $copy;
	}

	/**
	 * Build and return a RequestInterface instance.
	 *
	 * @return \Psr\Http\Message\RequestInterface The built request.
	 */
	public function build(): RequestInterface
	{
		$request = $this->requestFactory->createRequest($this->getMethod(), $this->getUri());

		if (!empty($this->protocolVersion)) {
			$request = $request->withProtocolVersion($this->protocolVersion);
		}

		$headers = $this->getHeaders();

		if (!empty($headers)) {
			foreach ($headers as $name => $values) {
				if (is_array($values)) {
					foreach ($values as $value) {
						$request = $request->withAddedHeader($name, $value);
					}
				} else {
					$request = $request->withHeader($name, $values);
				}
			}
		}

		$body = $this->getBody();

		if (!is_null($body)) {
			$request = $request->withBody($body);
		}

		return $request;
	}

	/**
	 * Get the HTTP method for the Request.
	 *
	 * @return string The HTTP method (e.g., 'GET', 'POST').
	 */
	protected function getMethod(): string
	{
		return 'GET';
	}

	/**
	 * Get the URI for the Request.
	 *
	 * @return \Psr\Http\Message\UriInterface
	 */
	protected function getUri(): UriInterface
	{
		$uri = $this->uriFactory
			->createUri('')
			->withScheme($this->scheme);

		if (!empty($this->host)) {
			$uri = $uri->withHost($this->host);
		}

		if (!is_null($this->port)) {
			$uri = $uri->withPort($this->port);
		}

		return $uri;
	}

	/**
	 * Get the headers for the Request.
	 *
	 * @return array<string, string>|array<string, array<int, string>>
	 */
	protected function getHeaders(): array
	{
		return [];
	}

	/**
	 * Get the body for the Request.
	 *
	 * @return \Psr\Http\Message\StreamInterface|null
	 */
	public function getBody(): ?StreamInterface
	{
		return null;
	}
}
