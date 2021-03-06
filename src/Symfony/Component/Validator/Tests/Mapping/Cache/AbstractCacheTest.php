<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Tests\Mapping\Cache;

use Symfony\Component\Validator\Mapping\Cache\CacheInterface;

abstract class AbstractCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CacheInterface
     */
    protected $cache;

    public function testWrite()
    {
        $meta = $this->getMockBuilder('Symfony\\Component\\Validator\\Mapping\\ClassMetadata')
            ->disableOriginalConstructor()
            ->setMethods(array('getClassName'))
            ->getMock();

        $meta->expects($this->once())
            ->method('getClassName')
            ->will($this->returnValue('Foo\\Bar'));

        $this->cache->write($meta);

        $this->assertInstanceOf(
            'Symfony\\Component\\Validator\\Mapping\\ClassMetadata',
            $this->cache->read('Foo\\Bar'),
            'write() stores metadata'
        );
    }

    public function testHas()
    {
        $meta = $this->getMockBuilder('Symfony\\Component\\Validator\\Mapping\\ClassMetadata')
            ->disableOriginalConstructor()
            ->setMethods(array('getClassName'))
            ->getMock();

        $meta->expects($this->once())
            ->method('getClassName')
            ->will($this->returnValue('Foo\\Bar'));

        $this->assertFalse($this->cache->has('Foo\\Bar'), 'has() returns false when there is no entry');

        $this->cache->write($meta);
        $this->assertTrue($this->cache->has('Foo\\Bar'), 'has() returns true when the is an entry');
    }

    public function testRead()
    {
        $meta = $this->getMockBuilder('Symfony\\Component\\Validator\\Mapping\\ClassMetadata')
            ->disableOriginalConstructor()
            ->setMethods(array('getClassName'))
            ->getMock();

        $meta->expects($this->once())
            ->method('getClassName')
            ->will($this->returnValue('Foo\\Bar'));

        $this->assertFalse($this->cache->read('Foo\\Bar'), 'read() returns false when there is no entry');

        $this->cache->write($meta);

        $this->assertInstanceOf(
            'Symfony\\Component\\Validator\\Mapping\\ClassMetadata',
            $this->cache->read('Foo\\Bar'),
            'read() returns metadata'
        );
    }
}
