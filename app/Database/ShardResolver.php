<?php

namespace App\Database;

use Illuminate\Support\Facades\Config;

/**
 * Resolves which database shard a given model record belongs to.
 *
 * Sharding strategy: range-based on the record's shard key (typically id).
 * Each shard maps to a separate Laravel DB connection that can point to a
 * different physical MySQL host/schema. If a shard connection is not configured
 * the system gracefully falls back to the default 'mysql' connection.
 *
 * Config reference (config/database.php connections):
 *   mysql        → shard 0 (default / primary)
 *   mysql_shard1 → shard 1
 *   mysql_shard2 → shard 2
 *   ...
 *
 * Environment variables (add to .env):
 *   DB_SHARD_COUNT=2          total number of shards (excluding primary)
 *   DB_SHARD_SIZE=100000      max rows per shard before spilling to next
 */
class ShardResolver
{
    private static int $shardCount;
    private static int $shardSize;

    public static function boot(): void
    {
        static::$shardCount = (int) config('database.sharding.count', 0);
        static::$shardSize  = (int) config('database.sharding.size', 100_000);
    }

    /**
     * Resolve the DB connection name for a given shard key.
     */
    public static function resolve(int|string $shardKey): string
    {
        static::boot();

        if (static::$shardCount === 0) {
            return config('database.default', 'mysql');
        }

        $shardIndex = static::shardIndex((int) $shardKey);

        return static::connectionName($shardIndex);
    }

    /**
     * Return the shard index (0-based) for a given key.
     */
    public static function shardIndex(int $key): int
    {
        static::boot();

        if (static::$shardSize > 0) {
            // Range-based sharding: records 0–shardSize on shard 0, etc.
            $index = intdiv($key, static::$shardSize);
        } else {
            // Hash-based fallback
            $index = $key % max(1, static::$shardCount + 1);
        }

        return min($index, static::$shardCount);
    }

    /**
     * Return connection name for shard index.
     * Shard 0 → default mysql connection.
     * Shard N → mysql_shardN connection (must be defined in config/database.php).
     */
    public static function connectionName(int $shardIndex): string
    {
        if ($shardIndex === 0) {
            return config('database.default', 'mysql');
        }

        $name = "mysql_shard{$shardIndex}";

        // Fall back to default if the shard connection is not configured
        if (Config::get("database.connections.{$name}") === null) {
            return config('database.default', 'mysql');
        }

        return $name;
    }

    /**
     * Return all configured shard connection names (including shard 0).
     *
     * @return string[]
     */
    public static function allConnections(): array
    {
        static::boot();

        return array_map(
            fn(int $i) => static::connectionName($i),
            range(0, static::$shardCount)
        );
    }
}
