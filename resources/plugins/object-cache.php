<?php
/*
Plugin Name: Memcached
Description: MemcacheD backend for the WP Object Cache.
Version: 6.0.2-plugins
Author: Mat Lipe

Special version for plugins repo so we can support Memcache
for older PHP versions and MemcacheD for newer.

*/

// Stop direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WP_CACHE_KEY_SALT' ) ) {
	define( 'WP_CACHE_KEY_SALT', DB_NAME );
}
if ( ! defined( 'WP_OBJECT_CACHE_COMPRESS' ) ) {
	define( 'WP_OBJECT_CACHE_COMPRESS', false );
}

/**
 * Adds data to the cache, if the cache key does not already exist.
 *
 * @param int|string $key    The cache key to use for retrieval later
 * @param mixed      $data   The data to add to the cache store
 * @param string     $group  The group to add the cache to
 * @param int        $expire When the cache data should be expired
 *
 * @return bool False if cache key and group already exist, true on success
 */
function wp_cache_add( $key, $data, $group = WP_Object_Cache::DEFAULT_GROUP, $expire = 0 ) {
	return WP_Object_Cache::instance()->add( $key, $data, $group, $expire );
}

/**
 * Closes the cache.
 *
 * This function has ceased to do anything since WordPress 2.5. The
 * functionality was removed along with the rest of the persistent cache. This
 * does not mean that plugins can't implement this function when they need to
 * make sure that the cache is cleaned up after WordPress no longer needs it.
 *
 * @return bool Always returns True
 */
function wp_cache_close() {
	return true;
}

/**
 * Decrement numeric cache item's value
 *
 * @param int|string $key    The cache key to increment
 * @param int        $offset The amount by which to decrement the item's value. Default is 1.
 * @param string     $group  The group the key is in.
 *
 * @return false|int False on failure, the item's new value on success.
 */
function wp_cache_decr( $key, $offset = 1, $group = WP_Object_Cache::DEFAULT_GROUP ) {
	return WP_Object_Cache::instance()->decr( $key, $offset, $group );
}

/**
 * Removes the cache contents matching key and group.
 *
 * @param int|string $key   What the contents in the cache are called
 * @param string     $group Where the cache contents are grouped
 *
 * @return bool True on successful removal, false on failure
 */
function wp_cache_delete( $key, $group = WP_Object_Cache::DEFAULT_GROUP ) {
	return WP_Object_Cache::instance()->delete( $key, $group );
}

/**
 * Removes all cache items.
 *
 * @return bool False on failure, true on success
 */
function wp_cache_flush() {
	return \WP_Object_Cache::instance()->flush();
}

/**
 * Retrieves the cache contents from the cache by key and group.
 *
 * @param int|string $key   What the contents in the cache are called
 * @param string     $group Where the cache contents are grouped
 * @param bool       $force Force pulling from the external cache instead of object classes "cache" property
 * @param null|bool  $found Set to true/false if we have a cached value.
 *
 * @return bool|mixed False on failure to retrieve contents, or the cache contents on success
 */
function wp_cache_get( $key, $group = WP_Object_Cache::DEFAULT_GROUP, $force = false, &$found = null ) {
	return WP_Object_Cache::instance()->get( $key, $group, $force, $found );
}

/**
 * Retrieves multiple values from the cache in one call.
 *
 * @param string[]|int[] $keys  Array of keys under which the cache contents are stored.
 * @param string         $group Where the cache contents are grouped.
 * @param bool           $force - Force pulling from the external cache instead of the cache property.
 *
 * @return array
 */
function wp_cache_get_multiple( $keys, $group = WP_Object_Cache::DEFAULT_GROUP, $force = false ) : array {
	return WP_Object_Cache::instance()->get_multi( $keys, $group, $force );
}

/**
 * Set multiple values to the cache in one call.
 *
 * @param array  $keys   Array of keys under which the cache contents are stored.
 * @param string $group  Where the cache contents are grouped.
 * @param int    $expire When to expire the cache contents in seconds.
 *
 * @return array<bool> - Array of keys and their status.
 */
function wp_cache_set_multiple( array $keys, $group = WP_Object_Cache::DEFAULT_GROUP, $expire = 0 ): array {
	return WP_Object_Cache::instance()->set_multi( $keys, $group, $expire );
}

/**
 * Increment numeric cache item's value
 *
 * @param int|string $key    The cache key to increment
 * @param int        $offset The amount by which to increment the item's value. Default is 1.
 * @param string     $group  The group the key is in.
 *
 * @return false|int False on failure, the item's new value on success.
 */
function wp_cache_incr( $key, $offset = 1, $group = WP_Object_Cache::DEFAULT_GROUP ) {
	return WP_Object_Cache::instance()->incr( $key, $offset, $group );
}

/**
 * Sets up Object Cache Global and assigns it.
 *
 * @global WP_Object_Cache $wp_object_cache WordPress Object Cache
 */
function wp_cache_init() {
	$GLOBALS['wp_object_cache'] = WP_Object_Cache::instance();
}

/**
 * Replaces the contents of the cache with new data.
 *
 * @param int|string $key    What to call the contents in the cache
 * @param mixed      $data   The contents to store in the cache
 * @param string     $group  Where to group the cache contents
 * @param int        $expire When to expire the cache contents
 *
 * @return bool False if not exists, true if contents were replaced
 */
function wp_cache_replace( $key, $data, $group = WP_Object_Cache::DEFAULT_GROUP, $expire = 0 ) {
	return WP_Object_Cache::instance()->replace( $key, $data, $group, $expire );
}

/**
 * Saves the data to the cache.
 *
 * @param int|string $key    What to call the contents in the cache
 * @param mixed      $data   The contents to store in the cache
 * @param string     $group  Where to group the cache contents
 * @param int        $expire When to expire the cache contents in seconds
 *
 * @return bool False on failure, true on success
 */
function wp_cache_set( $key, $data, $group = WP_Object_Cache::DEFAULT_GROUP, $expire = 0 ) {
	return WP_Object_Cache::instance()->set( $key, $data, $group, $expire );
}

/**
 * Switch the internal blog id.
 *
 * This changes the blog id used to create keys in blog specific groups.
 *
 * @param int $blog_id Blog ID
 */
function wp_cache_switch_to_blog( $blog_id ) {
	WP_Object_Cache::instance()->switch_to_blog( $blog_id );
}

/**
 * Adds a group or set of groups to the list of global groups.
 *
 * @param string|array $groups A group, or an array of groups to add
 */
function wp_cache_add_global_groups( $groups ) {
	WP_Object_Cache::instance()->add_global_groups( $groups );
}

/**
 * Add a group or set of groups to list of non persistent groups
 *
 * @param string|array $groups A group, or an array of groups to add
 */
function wp_cache_add_non_persistent_groups( $groups ) {
	WP_Object_Cache::instance()->add_non_persistent_groups( $groups );
}

/**
 * Removes all cache items from the in-memory runtime cache.
 *
 * Does not flush the persistent cache.
 *
 * @see   wp_cache_flush_runtime()
 *
 * @return bool True on success, false on failure.
 */
function wp_cache_flush_runtime(): bool {
	WP_Object_Cache::instance()->cache = [];
	return true;
}

class WP_Object_Cache {
	public const DEFAULT_GROUP = 'default';

	/**
	 * @var int Keeps count of how many times the
	 *    cache was successfully received from OPcache
	 */
	public $cache_hits = 0;

	/**
	 * @var int Keeps count of how many times the
	 *    cache was not successfully received from OPcache
	 */
	public $cache_misses = 0;

	/**
	 * @var array Holds a list of cache groups that are
	 *    shared across all sites in a multi-site installation
	 */
	protected $global_groups = [];

	/**
	 * @var array Groups which do not have a persistent cache.
	 */
	protected $no_cache_groups = [];

	/**
	 * This only differs if running a multi-site installations.
	 *
	 * @var int The sites current blog ID.
	 */
	protected $blog_prefix;

	public $global_prefix;

	public $cache = [];

	public $stats = [];

	public $group_ops = [];

	/**
	 * Sets the list of global groups.
	 *
	 * @param string|array $groups List of groups that are global.
	 */
	public function add_global_groups( $groups ) : void {
		if ( ! is_array( $groups ) ) {
			$groups = (array) $groups;
		}

		$this->global_groups = array_merge( $this->global_groups, $groups );
		$this->global_groups = array_unique( $this->global_groups );
	}


	public function add_non_persistent_groups( $groups ) : void {
		if ( ! is_array( $groups ) ) {
			$groups = (array) $groups;
		}

		$this->no_cache_groups = array_merge( $this->no_cache_groups, $groups );
		$this->no_cache_groups = array_unique( $this->no_cache_groups );
	}


	public function remove_non_persistent_groups( $groups ) : void {
		if ( ! is_array( $groups ) ) {
			$groups = (array) $groups;
		}

		$this->no_cache_groups = array_diff( $this->no_cache_groups, $groups );
	}


	/**
	 * Store the action in stats
	 *
	 * @param string $action
	 * @param string $group
	 * @param string $id
	 *
	 * @return void
	 */
	protected function update_stats( $action, $group, $id ) : void {
		if ( ! isset( $this->stats[ $action ] ) ) {
			$this->stats[ $action ] = 0;
		}
		$this->stats[ $action ] ++;

		$this->group_ops[ $group ][] = [ $action => $id ];
	}


	/**
	 * Reset the stats while bringing back the original keys.
	 */
	protected function reset_stats() : void {
		$this->stats = [
			'add'       => 0,
			'delete'    => 0,
			'external'  => 0,
			'get'       => 0,
			'get_multi' => 0,
			'miss'      => 0,
			'set'       => 0,
			'set_multi' => 0
		];
	}


	public function stats() : void {
		?>
		<table>
			<?php
			foreach ( $this->stats as $stat => $n ) {
				?>
				<tr>
					<td>

						<a href="<?= add_query_arg( 'show_only', $stat ) ?>">
							<?= $this->colorize_command( $stat ) ?>
						</a>
					</td>
					<td>
						<strong><?= $n ?></strong>
					</td>
				</tr>
				<?php
			}
			?>
		</table>
		<h3><?= $this->get_cache_type() ?> Object Cache:</h3>
		<?php

		foreach ( $this->group_ops as $group => $ops ) {
			if ( ! isset( $_GET['show_only'] ) && ! isset( $_GET['debug_queries'] ) && 200 < \count( $ops ) ) {
				$ops = \array_slice( $ops, 0, 200 );
				?>
				Too many to show!
				<a href=" <?= add_query_arg( 'debug_queries', true ) ?>">
					Click to show all results
				</a>
				<br />
				<?php
			}
			?>
			<h4><?= esc_html( $group ) ?> group</h4>
			<table>
				<thead>
					<tr>
						<th><strong>Command</strong></th>
						<th><strong>Key</strong></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $ops as $_command ) {
						if ( isset( $_GET['show_only'] ) && \key( $_command ) !== $_GET['show_only'] ) {
							continue;
						}
						?>
						<tr>
							<td><?= $this->colorize_command( \key( $_command ) ) ?></td>
							<td><?= \trim( \reset( $_command ) ) ?></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<?php
		}
		// phpcs:enable
	}


	protected function colorize_command( string $cmd ) : string {
		$colors = [
			'add'       => 'blue',
			'delete'    => 'brown',
			'external'  => 'orange',
			'get'       => 'green',
			'get_multi' => 'teal',
			'miss'      => 'red',
			'set'       => 'purple',
			'set_multi' => 'violet',
		];

		return "<span style='font-weight: 700;color:{$colors[$cmd]};'>" . \trim( $cmd ) . '</span>';
	}
	/**
	 * Memcache servers organized by cache groups.
	 *
	 * Different buckets may be used for different groups.
	 *
	 * @var Memcached[]
	 */
	protected $mc = [];


	/**
	 * __clone not allowed
	 */
	private function __clone() {
	}


	/**
	 * Use for stat reports.
	 *
	 * @return string
	 */
	protected function get_cache_type() : string {
		return 'Memcached';
	}


	/**
	 * Adds data to the cache, if the cache id does not already exist.
	 *
	 * @param int|string $id - What the contents in the cache are called.
	 * @param mixed      $data   The data to add to the cache store.
	 * @param string     $group  The group to add the cache to.
	 * @param int        $expire When the cache data should be expired.
	 *
	 * @return bool False if cache id and group already exist, true on success
	 */
	public function add( $id, $data, $group = self::DEFAULT_GROUP, int $expire = 0 ) : bool {
		if ( wp_suspend_cache_addition() ) {
			return false;
		}
		$key = $this->key( $id, $group );

		if ( is_object( $data ) ) {
			$data = clone $data;
		}

		if ( in_array( $group, $this->no_cache_groups, true ) ) {
			$this->cache[ $key ] = $data;

			return true;
		}

		if ( isset( $this->cache[ $key ] ) && false !== $this->cache[ $key ] ) {
			return false;
		}

		$mc =& $this->get_mc( $group );
		$result = $mc->add( $key, $data, $expire );

		if ( false !== $result ) {
			$this->update_stats( 'add', $group, $id );
			$this->cache[ $key ] = $data;
		}

		return $result;
	}


	/**
	 * If a value does not exist in the cache we can't increment
	 * it, so we add it first. Memcache will do nothing when add is
	 * called on an existing key.
	 *
	 * @param int|string $id - What the contents in the cache are called.
	 * @param int    $offset - Count to increment.
	 * @param string $group - Where the cache contents are grouped.
	 *
	 * @return int
	 */
	public function incr( string $id, int $offset = 1, string $group = self::DEFAULT_GROUP ) : int {
		$key = $this->key( $id, $group );
		$mc =& $this->get_mc( $group );
		$mc->add( $key, 0 );
		$this->cache[ $key ] = (int) $mc->increment( $key, $offset );

		return $this->cache[ $key ];
	}


	/**
	 * The returned value will never be lower than 0, if a value does
	 * not exist in the cache, it will always return 0.
	 *
	 * @param int|string $id - What the contents in the cache are called.
	 * @param int    $offset
	 * @param string $group - Where the cache contents are grouped.
	 *
	 * @return int
	 */
	public function decr( string $id, int $offset = 1, string $group = self::DEFAULT_GROUP ) : int {
		$key = $this->key( $id, $group );
		$mc =& $this->get_mc( $group );
		$this->cache[ $key ] = (int) $mc->decrement( $key, $offset );

		return $this->cache[ $key ];
	}


	/**
	 * Remove the contents of the cache key in the group
	 *
	 * If the cache key does not exist in the group, then nothing will happen.
	 *
	 * @param int|string $id    - What the contents in the cache are called.
	 * @param string     $group - Where the cache contents are grouped.
	 *
	 * @return bool False if the contents weren't deleted and true on success
	 */
	public function delete( $id, $group = self::DEFAULT_GROUP ) : bool {
		$key = $this->key( $id, $group );
		unset( $this->cache[ $key ] );
		if ( in_array( $group, $this->no_cache_groups, true ) ) {
			return true;
		}

		$mc =& $this->get_mc( $group );

		$result = $mc->delete( $key );
		$this->update_stats( 'delete', $group, $id );

		return $result;
	}


	/**
	 * Flush all known Memcache buckets
	 *
	 * @return bool
	 */
	public function flush() : bool {
		$this->cache = [];
		$this->reset_stats();
		foreach ( $this->mc as $group => $mc ) {
			if ( ! $mc->flush() ) {
				return false;
			}
		}
		return true;
	}


	/**
	 * Retrieves the cache contents, if it exists
	 *
	 * The contents will be first attempted to be retrieved by searching by the
	 * id in the cache id. If the cache is hit (found) then the contents
	 * are returned.
	 *
	 * On failure, the number of cache misses will be incremented.
	 *
	 * @param int|string $id    - What the contents in the cache are called.
	 * @param string     $group - Where the cache contents are grouped.
	 * @param bool       $force - Force pulling from memcache instead of this class' "cache" property.
	 * @param null|bool  $found - Set to true/false if we have a cached value
	 *
	 * @return bool|mixed False on failure to retrieve contents, or the cache contents on found
	 */
	public function get( $id, $group = self::DEFAULT_GROUP, $force = false, &$found = null ) {
		$key = $this->key( $id, $group );
		$mc =& $this->get_mc( $group );
		$value = false;
		$found = false;

		if ( isset( $this->cache[ $key ] ) && ( ! $force || in_array( $group, $this->no_cache_groups, true ) ) ) {
			if ( is_object( $this->cache[ $key ] ) ) {
				$value = clone $this->cache[ $key ];
			} else {
				$value = $this->cache[ $key ];
			}
			$found = true;
			$this->update_stats( 'get', $group, $id );
		} elseif ( in_array( $group, $this->no_cache_groups, true ) ) {
			$this->cache[ $key ] = $value;
		} else {
			$value = $mc->get( $key );
			if ( is_int( $value ) && - 1 === $value ) {
				$value = false;
			}
			if ( empty( $value ) ) {
				$found = $mc->getResultCode() !== Memcached::RES_NOTFOUND;
			} else {
				$found = true;
			}
			$this->cache[ $key ] = $value;
			++ $this->cache_hits;
			$this->update_stats( 'external', $group, $id );
		}
		if ( ! $found ) {
			$this->update_stats( 'miss', $group, $id );
		}

		return $value;
	}


	/**
	 * Retrieve multiple values at once.
	 * Faster than retrieving individual values.
	 *
	 * @param array  $keys  - Array of keys to retrieve.
	 * @param string $group - Where the cache contents are grouped
	 *
	 * @param bool   $force - Force pulling from the external cache instead of the cache property.
	 *
	 * @return mixed[]
	 */
	public function get_multi( array $keys, string $group = self::DEFAULT_GROUP, $force = false ) : array {
		$keys = \array_unique( $keys );
		$return = [];
		$keys_to_get = [];
		$mc =& $this->get_mc( $group );
		foreach ( $keys as $id ) {
			$key = $this->key( $id, $group );
			if ( ! $force && isset( $this->cache[ $key ] ) ) {
				if ( is_object( $this->cache[ $key ] ) ) {
					$return[ $key ] = clone $this->cache[ $key ];
				} else {
					$return[ $key ] = $this->cache[ $key ];
				}
				$this->update_stats( 'get', $group, $id );
				continue;
			}
			if ( \in_array( $group, $this->no_cache_groups, true ) ) {
				$return[ $key ] = false;
				continue;
			}

			$keys_to_get[ $key ] = $id;
			$return[ $key ] = false;
		}

		if ( ! empty( $keys_to_get ) ) {
			$results = $mc->getMulti( \array_keys( $keys_to_get ), Memcached::GET_PRESERVE_ORDER );
			$return = \array_merge( $return, $results );
			\array_walk( $results, function( $value, $key ) use ( $keys_to_get, $group ) {
				$this->update_stats( null === $value ? 'miss' : 'external', $group, $keys_to_get[ $key ] );
			} );
		}

		$this->update_stats( 'get_multi', $group, \implode( ', ', $keys ) );
		$this->cache = \array_merge( $this->cache, $return );

		return \array_combine( $keys, \array_values( $return ) );
	}


	/**
	 * Set multiple values at once.
	 * Faster than setting individual values.
	 *
	 * @param mixed[] $data - Array of keys to set.
	 * @param string  $group  - Where the cache contents are grouped.
	 * @param int     $expire - When to expire the cache contents in seconds.
	 *
	 * @return array<bool> - Array of keys and their status.
	 */
	public function set_multi( array $data, $group = self::DEFAULT_GROUP, int $expire = 0 ): array {
		$sets = [];
		$mc = $this->get_mc( $group );

		foreach ( $data as $id => $item ) {
			$key = $this->key( $id, $group );
			if ( \is_object( $item ) ) {
				$item = clone $item;
			}
			$this->cache[ $key ] = $item;
			if ( \in_array( $group, $this->no_cache_groups, true ) ) {
				continue;
			}
			$sets[ $key ] = $item;
			$this->update_stats( 'set', $group, $id );
		}

		$result = false;
		if ( \count( $sets ) > 0 ) {
			$result = $mc->setMulti( $sets, $expire );
			$this->update_stats( 'set_multi', $group, implode( ', ', \array_keys( $data ) ) );
		}
		return \array_fill_keys( \array_keys( $data ), $result );
	}


	/**
	 * Works out a cache id based on a given id and group
	 *
	 * @param int|string $key   The id
	 * @param string     $group The group
	 *
	 * @return string Returns the calculated cache id
	 */
	public function key( $key, $group ) : string {
		if ( empty( $group ) ) {
			$group = self::DEFAULT_GROUP;
		}

		if ( in_array( $group, $this->global_groups, true ) ) {
			$prefix = $this->global_prefix;
		} else {
			$prefix = $this->blog_prefix;
		}

		return preg_replace( '/\s+/', '', "$group:$key:$prefix:" . WP_CACHE_KEY_SALT );
	}


	/**
	 * Replace the contents in the cache, if contents already exist
	 *
	 * @param string $id     - What to call the contents in the cache
	 * @param mixed  $data   - The contents to store in the cache
	 * @param string $group  - Where to group the cache contents
	 * @param int    $expire - When to expire the cache contents
	 *
	 * @return bool False if not exists, true if contents were replaced
	 */
	public function replace( $id, $data, $group = self::DEFAULT_GROUP, int $expire = 0 ) : bool {
		$key = $this->key( $id, $group );
		$mc =& $this->get_mc( $group );

		if ( is_object( $data ) ) {
			$data = clone $data;
		}

		$result = $mc->replace( $key, $data, $expire );
		if ( false !== $result ) {
			$this->cache[ $key ] = $data;
		}

		return $result;
	}


	/**
	 * Sets the data contents into the cache
	 *
	 * @param int|string $id     What to call the contents in the cache
	 * @param mixed      $data   The contents to store in the cache
	 * @param string     $group  Where to group the cache contents
	 * @param int        $expire When to expire the cache contents in seconds
	 *
	 * @return bool True if cache set successfully else false
	 */
	public function set( $id, $data, $group = self::DEFAULT_GROUP, int $expire = 0 ) : bool {
		$key = $this->key( $id, $group );
		if ( is_object( $data ) ) {
			$data = clone $data;
		}

		$this->cache[ $key ] = $data;

		if ( in_array( $group, $this->no_cache_groups, true ) ) {
			return true;
		}

		$mc =& $this->get_mc( $group );
		$result = $mc->set( $key, $data, $expire );

		if ( false !== $result ) {
			$this->update_stats( 'set', $group, $id );
		}

		return $result;
	}


	/**
	 * Switch the internal blog id.
	 *
	 * This changes the blog id used to create keys in blog specific groups.
	 *
	 * @param int $blog_id Blog ID
	 */
	public function switch_to_blog( $blog_id ) : void {
		global $table_prefix;
		$blog_id = (int) $blog_id;
		$this->blog_prefix = ( is_multisite() ? $blog_id : $table_prefix );
	}


	/**
	 * Get the instand of Memcached based on a group.
	 *
	 * Different buckets may be used for different cache groups.
	 *
	 * @param string $group - Cache group.
	 *
	 * @return Memcached
	 */
	protected function &get_mc( string $group = self::DEFAULT_GROUP ) : Memcached {
		if ( isset( $this->mc[ $group ] ) ) {
			return $this->mc[ $group ];
		}

		return $this->mc[ self::DEFAULT_GROUP ];
	}


	/**
	 * Connect the memcache server.
	 */
	public function __construct() {
		global $blog_id, $table_prefix, $memcached_servers;;
		$this->global_prefix =
			( is_multisite() || ( defined( 'CUSTOM_USER_TABLE' ) && defined( 'CUSTOM_USER_META_TABLE' ) ) ) ? 'global' : $table_prefix;
		$this->blog_prefix = is_multisite() ? $blog_id : $table_prefix;
		$this->reset_stats();
		$this->cache_hits =& $this->stats['get'];
		$this->cache_misses =& $this->stats['miss'];

		if ( ! defined( 'WP_CACHE_KEY_SALT' ) ) {
			define( 'WP_CACHE_KEY_SALT', 'wp' === basename( ABSPATH ) ? basename( dirname( ABSPATH ) ) : basename( ABSPATH ) );
		}

		$buckets = [ '127.0.0.1:11211' ];
		if ( null !== $memcached_servers ) {
			$buckets = $memcached_servers;
		}

		\reset( $buckets );
		if ( is_int( \key( $buckets ) ) ) {
			$buckets = [ self::DEFAULT_GROUP => $buckets ];
		}

		foreach ( $buckets as $bucket => $servers ) {
			$this->mc[ $bucket ] = new Memcached();
			$this->mc[ $bucket ]->setOption( Memcached::OPT_COMPRESSION, WP_OBJECT_CACHE_COMPRESS );
			$instances = [];
			foreach ( (array) $servers as $server ) {
				if ( 0 === strpos( $server, 'unix://' ) ) {
					$node = $server;
					$port = 0;
				} else {
					[ $node, $port ] = explode( ':', $server );
					if ( ! $port ) {
						$port = ini_get( 'memcache.default_port' );
					}
					$port = (int) $port;
					if ( ! $port ) {
						$port = 11211;
					}
				}
				$instances[] = [ $node, $port, 1 ];
			}
			$this->mc[ $bucket ]->addServers( $instances );
		}

	}


	/**
	 * Singleton. Return instance of WP_Object_Cache.
	 *
	 * @return \WP_Object_Cache
	 */
	public static function instance() : \WP_Object_Cache {
		global $wp_object_cache;

		if ( null === $wp_object_cache ) {
			$wp_object_cache = new \WP_Object_Cache();
		}

		return $wp_object_cache;
	}
}
