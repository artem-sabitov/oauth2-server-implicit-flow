<?php

declare(strict_types=1);

namespace OAuth2Test;

use OAuth2\Exception;
use OAuth2\Factory\ImplicitHandlerFactory;
use OAuth2\Handler\ImplicitGrant;
use OAuth2\Provider\ClientProviderInterface;
use OAuth2\TokenRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;

class ImplicitHandlerFactoryTest extends TestCase
{
    /**
     * @var ContainerInterface|ObjectProphecy
     */
    private $container;

    /**
     * @var ImplicitHandlerFactory
     */
    private $factory;

    /**
     * @var ClientProviderInterface
     */
    private $clientProvider;

    /**
     * @var TokenRepositoryInterface
     */
    private $tokenRepository;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
        $this->factory = new ImplicitHandlerFactory();
        $this->clientProvider = $this->prophesize(ClientProviderInterface::class);
        $this->tokenRepository = $this->prophesize(TokenRepositoryInterface::class);

        $this->container
            ->get(ClientProviderInterface::class)
            ->willReturn($this->clientProvider);
        $this->container
            ->get(TokenRepositoryInterface::class)
            ->willReturn($this->tokenRepository);
    }

    public function testFactoryWithoutConfig()
    {
        $this->container->get('config')->willReturn([]);
        $this->expectException(Exception\InvalidConfigException::class);
        $this->expectExceptionMessage('Cannot create OAuth2\Handler\ImplicitGrant handler; config oauth2.implicit_flow is missing');
        ($this->factory)($this->container->reveal());
    }

    public function testFactoryWithoutHandlersConfig()
    {
        $this->container->get('config')->willReturn(['oauth2' => []]);
        $this->expectException(Exception\InvalidConfigException::class);
        $this->expectExceptionMessage('Cannot create OAuth2\Handler\ImplicitGrant handler; config oauth2.implicit_flow is missing');
        ($this->factory)($this->container->reveal());
    }

    public function testFactoryWithoutClientProvider()
    {
        $handler = ImplicitGrant::class;
        $dependency = ClientProviderInterface::class;

        $this->container->get('config')->willReturn([
            'oauth2' => [
                'implicit_flow' => [],
            ],
        ]);
        $this->container->has(ClientProviderInterface::class)->willReturn(false);
        $this->expectException(Exception\InvalidConfigException::class);
        $this->expectExceptionMessage(sprintf(
            'Cannot create %s handler; dependency %s is missing',
            $handler,
            $dependency
        ));
        ($this->factory)($this->container->reveal());
    }

    public function testFactoryWithoutTokenRepository()
    {
        $handler = ImplicitGrant::class;
        $dependency = TokenRepositoryInterface::class;

        $this->container->get('config')->willReturn([
            'oauth2' => [
                'implicit_flow' => [],
            ],
        ]);
        $this->container->has(ClientProviderInterface::class)->willReturn(true);
        $this->container->has(TokenRepositoryInterface::class)->willReturn(false);
        $this->expectException(Exception\InvalidConfigException::class);
        $this->expectExceptionMessage(sprintf(
            'Cannot create %s handler; dependency %s is missing',
            $handler,
            $dependency
        ));
        ($this->factory)($this->container->reveal());
    }

    public function testFactory()
    {
        $this->container->get('config')->willReturn([
            'oauth2' => [
                'implicit_flow' => [],
            ],
        ]);
        $this->container->has(ClientProviderInterface::class)->willReturn(true);
        $this->container->has(TokenRepositoryInterface::class)->willReturn(true);
        $server = ($this->factory)($this->container->reveal());
        $this->assertInstanceOf(ImplicitGrant::class, $server);
    }
}