<?php
namespace MemcachedManager;

class MemcachedHandler extends \Memcached
{
	private $prefix;
    private $host;
    private $port;

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
	public function __construct($prefix = '', $host = 'localhost', $port = 11211, $persistent_id = null)
	{
		parent::__construct($persistent_id);
        $this->host = $host;
        $this->port = 11211;
        $this->addServer($this->host, $this->port);
        $this->prefix = $prefix;
        if(empty($prefix)) {
            $this->prefix = (string) rand(100, 999);
        }
	}

	/**
	 * @param string $prefix
     * @codeCoverageIgnore
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
	}

	/**
	 * @return string
     * @codeCoverageIgnore
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->host;
    }
	/**
	 * @inheritdoc
	 */
	public function add($key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::add($key, $value, $expiration);
	}

	/**
	 * @inheritdoc
	 */
	public function addByKey($server_key, $key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::addByKey($server_key, $key, $value, $expiration);
	}

	/**
	 * @inheritdoc
	 */
	public function append($key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::append($key, $value, $expiration);
	}

	/**
	 * @inheritdoc
	 */
	public function appendByKey($server_key, $key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::appendByKey($server_key, $key, $value, $expiration = null);
	}

	/**
	 * @inheritdoc
	 */
	public function cas($cas_token, $key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::cas($cas_token, $key, $value, $expiration);
	}

	/**
	 * @inheritdoc
	 */
	public function casByKey($cas_token, $server_key, $key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::casByKey($cas_token, $server_key, $key, $value, $expiration = null);
	}

	/**
	 * @inheritdoc
	 */
	public function decrement($key, $offset = 1, $initial_value = 0, $expiry = 0)
	{
		$key = $this->prefix . $key;
		return parent::decrement($key, $offset, $initial_value, $expiry);
	}

	/**
	 * @inheritdoc
	 */
	public function decrementByKey($server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0)
	{
		$key = $this->prefix . $key;
		return parent::decrementByKey($server_key, $key, $offset, $initial_value, $expiry);
	}

	/**
	 * @inheritdoc
	 */
	public function delete($key, $time = 0)
	{
		$key = $this->prefix . $key;
		return parent::delete($key, $time);
	}

	/**
	 * @inheritdoc
	 */
	public function deleteByKey($server_key, $key, $time = 0)
	{
		$key = $this->prefix . $key;
		return parent::deleteByKey($server_key, $key, $time);
	}

	/**
	 * Add the prefix to an array of keys
	 *
	 * @param array $keys
	 * @return array
	 */
	private function prefixArrayOfKeys(array $keys)
	{
		$prefixedKeys = array();
		foreach ($keys as $key) {
			$prefixedKeys[] = $this->prefix . $key;
		}
		return $prefixedKeys;
	}

	/**
	 * @inheritdoc
	 */
	public function deleteMulti($keys, $time = null)
	{
		$keys = $this->prefixArrayOfKeys($keys);
		return parent::deleteMulti($keys, $time);
	}

	/**
	 * @inheritdoc
	 */
	public function deleteMultiByKey($server_key, $keys, $time = null)
	{
		$keys = $this->prefixArrayOfKeys($keys);
		return parent::deleteByKey($server_key, $keys, $time);
	}

	/**
	 * @inheritdoc
	 */
	public function get($key, $cache_kb = null, &$cas_token = null)
	{
		$key = $this->prefix . $key;
		return parent::get($key, $cache_kb, $cas_token);
	}

	/**
	 * @inheritdoc
	 */
	public function getByKey($server_key, $key, $cache_kb = null, &$cas_token = null)
	{
		$key = $this->prefix . $key;
		return parent::get($key, $cache_kb, $cas_token);
	}

	/**
	 * @inheritdoc
	 */
	public function getDelayed(array $keys, $with_cas = null, $value_cb = null)
	{
		$keys = $this->prefixArrayOfKeys($keys);
		return parent::getDelayed($keys, $with_cas, $value_cb);
	}

	/**
	 * @inheritdoc
	 */
	public function getDelayedByKeys($server_key, array $keys, $with_cas = false, callable $value_cb = null)
	{
		$keys = $this->prefixArrayOfKeys($keys);
		return parent::getDelayed($server_key, $keys, $with_cas, $value_cb);
	}

	/**
	 * @inheritdoc
	 */
	public function getMulti(array $keys, &$cas_tokens = array(), $flags = null)
	{
		$keys = $this->prefixArrayOfKeys($keys);
		return parent::getMulti($keys, $cas_tokens, $flags);
	}

	/**
	 * @inheritdoc
	 */
	public function getMultiByKey($server_key, array $keys, &$cas_tokens = array(), $flags = null)
	{
		$keys = $this->prefixArrayOfKeys($keys);
		return parent::getMultiByKey($server_key, $keys, $cas_tokens, $flags);
	}

	/**
	 * @inheritdoc
	 */
	public function increment($key, $offset = 1, $initial_value = 0, $expiry = 0)
	{
		$key = $this->prefix . $key;
		return parent::increment($key, $offset, $initial_value, $expiry);
	}

	/**
	 * @inheritdoc
	 */
	public function incrementByKey($server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0)
	{
		$key = $this->prefix . $key;
		return parent::incrementByKey($server_key, $key, $offset, $initial_value, $expiry);
	}

	/**
	 * @inheritdoc
	 */
	public function prepend($key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::prepend($key, $value, $expiration);
	}

	/**
	 * @inheritdoc
	 */
	public function prependByKey($server_key, $key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::prependByKey($server_key, $key, $value, $expiration);
	}

	/**
	 * @inheritdoc
	 */
	public function replace($key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::replace($key, $value, $expiration);
	}

	/**
	 * @inheritdoc
	 */
	public function replaceByKey($server_key, $key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::replaceByKey($server_key, $key, $value, $expiration);
	}

	/**
	 * @inheritdoc
	 */
	public function set($key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::set($key, $value, $expiration);
	}

	/**
	 * @inheritdoc
	 */
	public function setByKey($server_key, $key, $value, $expiration = null)
	{
		$key = $this->prefix . $key;
		return parent::setByKey($server_key, $key, $value, $expiration);
	}

	/**
	 * Add the prefix to the keys of the given array
	 *
	 * @param array $items
	 * @return array
	 */
	private function prefixArrayKeys(array $items)
	{
		$prefixed = array();
		foreach ($items as $key => $value) {
			$prefixed[$this->prefix . $key] = $value;
		}
		return $prefixed;
	}

	/**
	 * @inheritdoc
	 */
	public function setMulti(array $items, $expiration = null)
	{
		$items = $this->prefixArrayKeys($items);
		return parent::setMulti($items, $expiration);
	}

	/**
	 * @inheritdoc
	 */
	public function setMultiByKey($server_key, array $items, $expiration = null)
	{
		$items = $this->prefixArrayKeys($items);
		return parent::setMultiByKey($server_key, $items, $expiration);
	}

	/**
	 * @inheritdoc
	 */
	public function touch($key, $expiration)
	{
		$key = $this->prefix . $key;
        return parent::touch($key, $expiration);
    }

    /**
     * @inheritdoc
     */
    public function touchByKey($server_key, $key, $expiration)
    {
        $key = $this->prefix . $key;
        return parent::touchByKey($server_key, $key, $expiration);
    }

	/**
	 * @inheritdoc
	 */
    public function getAllKeys()
    {
        $keys = parent::getAllKeys();
        foreach ($keys as $key => $cacheKey) {
            if (strpos($cacheKey, $this->prefix) !== 0) {
                unset($keys[$key]);
            }
        }
        return $keys;
    }

    /**
     * Delete of items for the set Key and throws exception if this is empty.
     *
     * @return bool
     *
     */
	public function deleteAllForKey()
	{
		$keys = $this->getAllKeys();
        return parent::deleteMulti($keys);
	}

	/**
	 * Delete all Keys for the given shell pattern
	 * @param  string $pattern A valid Shell pattern
	 * @param  int    $flags   Constant for fnmatch (http://php.net/manual/es/function.fnmatch.php)
	 * @return bool          True if success False if fails.
	 */
	public function shellPatternDelete($pattern, $flags = 0)
	{
		$keys = $this->getAllKeys();
		$deleted = false;
		foreach ($keys as $i => $key) {
			if (!fnmatch($this->prefix . $pattern, $key, $flags)) {
				unset($keys[$i]);
				continue;
			}
			$deleted = parent::delete($key);
		}
		return $deleted;
	}
}
