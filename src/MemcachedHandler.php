<?php 
namespace MemcachedManager;

class MemcachedHandler extends \Memcached 
{
	private $prefix;

	public function __construct($prefix = '', $persistent_id = null)
	{
		parent::__construct($persistent_id);
		$this->prefix = $prefix;
	}

	/**
	 * @param string $prefix
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
	}

	/**
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->prefix;
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
	public function append($key, $value)
	{
		$key = $this->prefix . $key;
		return parent::append($key, $value);
	}

	/**
	 * @inheritdoc
	 */
	public function appendByKey($server_key, $key, $value)
	{
		$key = $this->prefix . $key;
		return parent::appendByKey($server_key, $key, $value);
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
    public function deleteMulti(array $keys, $time = 0)
    {
        $keys = $this->prefixArrayOfKeys($keys);
        return parent::deleteMulti($keys, $time);
    }

    /**
     * @inheritdoc
     */
    public function deleteMultiByKey($server_key, array $keys, $time = 0)
    {
        $keys = $this->prefixArrayOfKeys($keys);
        return parent::deleteByKey($server_key, $keys, $time);
    }

    /**
     * @inheritdoc
     */
    public function get($key, callable  $cache_kb, &$cas_token = null)
    {
        $key = $this->prefix . $key;
        return parent::get($key, $cache_kb, $cas_token);
    }


}
