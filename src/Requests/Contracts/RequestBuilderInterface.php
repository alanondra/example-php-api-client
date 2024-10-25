<?php

declare(strict_types=1);

namespace AOndra\ExampleApi\Requests\Contracts;

use Psr\Http\Message\{
	RequestInterface,
	RequestFactoryInterface,
	StreamFactoryInterface,
	UriFactoryInterface,
};

interface RequestBuilderInterface
{
	/**
	 * Set the RequestFactory instance.
	 *
	 * @param \Psr\Http\Message\RequestFactoryInterface $requestFactory
	 *
	 * @return void
	 */
	public function setRequestFactory(RequestFactoryInterface $requestFactory): void;

	/**
	 * Set the StreamFactory instance.
	 *
	 * @param \Psr\Http\Message\StreamFactoryInterface $streamFactory
	 *
	 * @return void
	 */
	public function setStreamFactory(StreamFactoryInterface $streamFactory): void;

	/**
	 * Set the UriFactory instance.
	 *
	 * @param \Psr\Http\Message\UriFactoryInterface $uriFactory
	 *
	 * @return void
	 */
	public function setUriFactory(UriFactoryInterface $uriFactory): void;

	/**
	 * Build a Request.
	 *
	 * @return \Psr\Http\Message\RequestInterface
	 */
	public function build(): RequestInterface;
}
