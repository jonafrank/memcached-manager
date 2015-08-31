<?php
namespace MemcachedManagerTests;

use MemcachedManager\MemcachedHandler;

class MemcachedHandlerTest extends \PHPUnit_Framework_TestCase
{
    private $memcached;
    private $handler;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->memcached = new \Memcached();
        $this->memcached->addServer('localhost', 11211);
        $this->handler = new MemcachedHandler('MHT_');
    }

    /**
     * @covers \MemcachedManager\MemcachedHandler::set
     */
    public function testSet()
    {
        $this->handler->set('setTest','test value');
        $value = $this->memcached->get('MHT_setTest');
        $this->assertEquals('test value', $value);
    }

    /**
     * @covers \MemcachedManager\MemcachedHandler::get
     * @depends testSet
     */
    public function testGet()
    {
        $value = $this->handler->get('setTest');
        $this->assertEquals('test value', $value);
    }

    /**
     * @covers \MemcachedManager\MemcachedHandler::delete
     * @depends testGet
     */
    public function testDelete()
    {
        $this->handler->delete('setTest');
        $this->assertFalse($this->memcached->get('MHT_setTest'));
    }

    /**
     * @covers \MemcachedManager\MemcachedHandler::deleteAllForKey
     * @depends testDelete
     */
    public function testDeleteAllForKey()
    {
        $this->handler->set('test1', 'value1');
        $this->handler->set('test2', 'value2');
        $this->handler->set('test3', 'value3');
        $this->memcached->set('noPrefixKey', 'value4');
        $this->handler->deleteAllForKey();
        $this->assertFalse($this->memcached->get('MHT_test1'));
        $this->assertFalse($this->memcached->get('MHT_test2'));
        $this->assertFalse($this->memcached->get('MHT_test3'));
        $this->assertEquals('value4', $this->memcached->get('noPrefixKey'));
        $this->memcached->delete('noPrefixKey');
    }

    /**
     * @covers \MemcachedManager\MemcachedHandler::deleteMulti
     * @depends testGet
     */
    public function testDeleteMulti()
    {

        $this->handler->set('test1', 'value1');
        $this->handler->set('test2', 'value2');
        $this->handler->set('test3', 'value3');
        $this->handler->deleteMulti(array('test1', 'test2'));
        $this->assertFalse($this->handler->get('test1'));
        $this->assertFalse($this->handler->get('test2'));
        $this->assertEquals('value3', $this->handler->get('test3'));
        $this->handler->delete('test3');
    }

    /**
     * @covers \MemcachedManager\MemcachedHandler::shellPatternDelete
     * @depends testDeleteMulti
     */
    public function testShellPatternDelete()
    {
        $this->handler->set('test1', 'value1');
        $this->handler->set('test2', 'value2');
        $this->handler->set('nodelete', 'value3');
        $res = $this->handler->shellPatternDelete('test*');
        $this->assertFalse($this->handler->get('test1'));
        $this->assertFalse($this->handler->get('test2'));
        $this->assertEquals('value3', $this->handler->get('nodelete'));
    }
}
