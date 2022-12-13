<?php

namespace App\Modules\Cache;

/**
 * Класс для работы с сервисами кэша использующие интерфейс \App\Modules\Cache\CacheInterface;
 * Если необходимо изменить сервис кэширования, то в конструкторе создаем класса необходимого сервиса
 *
 * !!! В текущей реализации возможно работать только с сервисами кэша, типа "Ключ->Значение"
 *
 * @property CacheInterface $cacheModule - объект класса сервиса кэша
 */
class CacheModule
{
    private CacheInterface $cacheModule;

    public function __construct()
    {
        $this->cacheModule = (new RedisCache())->connection();
    }

    public function set(string $key, string|array $value, $ttl = 3600): void
    {
        $this->cacheModule->set($key, $value, 'ex', $ttl);
    }

    public function get(string $key): array|string|null
    {
        return $this->cacheModule->get($key);
    }

    public function delete(string|array $key): void
    {
        $this->cacheModule->delete($key);
    }

    public function update(string $key, string|array $value, $ttl = 3600): void
    {
        $this->cacheModule->update($key, $value, $ttl);
    }
}