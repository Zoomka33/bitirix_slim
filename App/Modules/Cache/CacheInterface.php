<?php

namespace App\Modules\Cache;

interface CacheInterface
{
    /**
     * Метод устанавливает с клиентом кэша
     *
     * @return $this
     */
    public function connection(): CacheInterface;

    /**
     * Метод записывает в кэш данные
     *
     * @param string $key - ключ кэша
     * @param string|array $value - значение кэша
     * @param int $ttl
     * @return mixed
     */
    public function set(string $key, string|array $value, int $ttl);

    /**
     * Метод возвращает данные из кэша
     *
     * @param string $key - ключ кэша
     * @return mixed
     */
    public function get(string $key);

    /**
     * Метод обновляет данные в кэше
     *
     * @param string $key - ключ
     * @param string|array $value - значение кэша
     * @param int $ttl - время жизни кэша
     * @return mixed
     */
    public function update(string $key, string|array $value, $ttl);

    /**
     * Метод удаляет данные в кэше
     *
     * @param string|array $key - ключ кэша
     * @return mixed
     */
    public function delete(string|array $key);
}