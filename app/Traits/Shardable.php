<?php

namespace App\Traits;

use App\Database\ShardResolver;

/**
 * Shardable trait — mixin for Eloquent models stored across multiple shards.
 *
 * Usage:
 *   1. Add `use Shardable;` to the model.
 *   2. Optionally override $shardKey (default: 'id') to choose the column
 *      used to compute the target shard.
 *   3. Optionally override $shardKeyStatic to hard-wire a specific shard
 *      (useful for tables that always live on shard 0, e.g. lookup tables).
 *
 * The trait resolves the DB connection automatically when:
 *   - Creating a new record  (resolves from Auth user or sequence)
 *   - Fetching by PK        (resolves from the key value)
 *   - Using ::onShard($key) (explicit resolution)
 */
trait Shardable
{
    /**
     * Column whose value is used to compute the shard index.
     * Override in the model to use a different column (e.g. 'taspen_id').
     */
    protected string $shardKey = 'id';

    /**
     * Hard-wire a specific shard index (null = auto-resolve).
     */
    protected ?int $shardKeyStatic = null;

    // -------------------------------------------------------------------------
    // Boot
    // -------------------------------------------------------------------------

    public static function bootShardable(): void
    {
        static::creating(function ($model) {
            if ($model->getConnectionName() === config('database.default')) {
                // No explicit connection set yet; let the model stay on the
                // default shard for new inserts (shard 0 / primary).
                return;
            }
        });

        static::retrieved(function ($model) {
            $model->setShardConnectionFromKey();
        });
    }

    // -------------------------------------------------------------------------
    // Connection resolution
    // -------------------------------------------------------------------------

    /**
     * Get the DB connection for this model instance based on its shard key.
     */
    public function getConnectionName(): string
    {
        if ($this->shardKeyStatic !== null) {
            return ShardResolver::connectionName($this->shardKeyStatic);
        }

        $keyValue = $this->getAttribute($this->shardKey)
            ?? $this->getAttribute($this->getKeyName());

        if ($keyValue === null) {
            return config('database.default', 'mysql');
        }

        return ShardResolver::resolve((int) $keyValue);
    }

    /**
     * Re-resolve the connection after the model is retrieved from DB.
     */
    protected function setShardConnectionFromKey(): void
    {
        $this->setConnection($this->getConnectionName());
    }

    // -------------------------------------------------------------------------
    // Query helpers
    // -------------------------------------------------------------------------

    /**
     * Return a query builder scoped to the shard that owns $shardKeyValue.
     *
     * Example:
     *   Application::onShard($applicationId)->where('status', 'active')->get();
     */
    public static function onShard(int|string $shardKeyValue): \Illuminate\Database\Eloquent\Builder
    {
        $connection = ShardResolver::resolve((int) $shardKeyValue);
        return static::on($connection);
    }

    /**
     * Run a callback against every configured shard and merge results.
     * Useful for aggregate queries (counts, totals) that span all shards.
     *
     * Example:
     *   $total = Application::acrossAllShards(fn($q) => $q->count());
     *   // returns summed integer
     *
     *   $records = Application::acrossAllShards(fn($q) => $q->where('status','active')->get());
     *   // returns merged Collection
     */
    public static function acrossAllShards(\Closure $callback): mixed
    {
        $connections = ShardResolver::allConnections();
        $results     = [];

        foreach ($connections as $connection) {
            $query   = static::on($connection);
            $result  = $callback($query);
            $results[] = $result;
        }

        // Merge collections
        if (isset($results[0]) && $results[0] instanceof \Illuminate\Support\Collection) {
            return collect($results)->flatten(1);
        }

        // Sum integers/floats
        if (is_numeric($results[0] ?? null)) {
            return array_sum($results);
        }

        return $results;
    }
}
