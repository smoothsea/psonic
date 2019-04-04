<?php


namespace Psonic\Concretes\Channels;
use Psonic\Concretes\Commands\Misc\PingCommand;
use Psonic\Concretes\Commands\Misc\QuitChannelCommand;
use Psonic\Contracts\Channel as ChannelInterface;
use Psonic\Contracts\Client;
use Psonic\Contracts\Command;
use Psonic\Contracts\Response;

abstract class Channel implements ChannelInterface
{
    /**
     * @var Client
     */
    protected $client;

    protected $bufferSize;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function connect()
    {
        return $this->client->connect();
    }

    public function disconnect()
    {
        $message = $this->client->send(new QuitChannelCommand);
         $this->client->disconnect();
        return $message;
    }

    public function ping(): Response
    {
        return $this->client->send(new PingCommand);
    }

    public function read(): Response
    {
        return $this->client->read();
    }

    public function send(Command $command): Response
    {
        return $this->client->send($command);
    }
}