<?php

namespace App\Modules\Cache;

use Predis\Client;
use Symfony\Component\Dotenv\Dotenv;
use App\Modules\Cache\CacheInterface;

/**
 * Редис кэш
 */
class RedisCache implements CacheInterface
{
    private Client $client;

    /**
     * @inheritDoc
     */
    public function connection(): RedisCache
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../http/.redis.env');
        $this->client = new Client([
            'scheme' => $_ENV['PROTOCOL'] ?? 'tcp',
            'host' => $_ENV['HOST'],
            'port' => $_ENV['PORT'],
        ]);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, string|array $value, $ttl = 3600): void
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $this->client->set($key, $value, 'ex', $ttl);
    }

    /**
     * @inheritDoc
     */
    public function get(string $key): array|string|null
    {
        $response = $this->client->get($key);

        if (json_decode($response)) {
            $response = json_decode($response, true);
        }

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function delete(string|array $key): void
    {
        $this->client->del($key);
    }

    /**
     * @inheritDoc
     */
    public function update(string $key, string|array $value, $ttl = 3600): void
    {
        $this->set($key, $value, $ttl);
    }
}