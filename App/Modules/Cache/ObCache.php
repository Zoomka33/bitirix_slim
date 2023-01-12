<?php

namespace App\Modules\Cache;

use Predis\Client;
use Symfony\Component\Dotenv\Dotenv;
use App\Modules\Cache\CacheInterface;
use \Bitrix\Main\Data\Cache;
use \Bitrix\Main\Application;
use \Bitrix\Main\Data\TaggedCache;
use \Bitrix\Main\Data\ManagedCache;

/**
 * Файловый кэш битрикса
 */
class ObCache implements CacheInterface
{
    private ManagedCache $client;

    /**
     * @inheritDoc
     */
    public function connection(): ObCache
    {
        $this->client = Application::getInstance()->getManagedCache();
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, string|array $value, $ttl = 3600): void
    {
        // для записи кэша обязательно вызвать read, тк там задается ttl
        $this->client->read($ttl, $key);
        $this->client->setImmediate($key, $value);
        return;
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, $ttl = 3600): array|string|null
    {
        return $this->client->getImmediate($ttl, $key);
    }

    /**
     * @inheritDoc
     */
    public function delete(string|array $key): void
    {
        $this->client->clean($key);
        return;
    }

    /**
     * @inheritDoc
     */
    public function update(string $key, string|array $value, $ttl = 3600): void
    {
        // для записи кэша обязательно вызвать clean и read, тк там задается ttl
        $this->client->clean($key);
        $this->client->read($ttl, $key);
        $this->client->setImmediate($key, $value);
        return;
    }
}