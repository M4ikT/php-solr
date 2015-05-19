<?php

namespace phpsolr
{
    class MapTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var \phpsolr\Map
         */
        private $map;

        protected function setUp()
        {
            $this->map = new Map();
        }

        public function testSetAndGetWorks()
        {
            $testValue = 'Hello World';
            $testKey = 'Hi';

            $this->map->set($testKey, $testValue);
            $this->assertSame($testValue, $this->map->get($testKey));

        }

        public function testMapIsInitiallyEmptyAndFilledAfterSet()
        {
            $this->assertTrue($this->map->isEmpty());
            $this->map->set('Hello', 'World');
            $this->assertFalse($this->map->isEmpty());

        }

        public function testIfHasWorks()
        {
            $this->map->set('Hello', 'World');
            $this->assertTrue($this->map->has('Hello'));
            $this->assertFalse($this->map->has('Bye'));
        }

        public function testIfRemoveWorks()
        {
            $key = 'Hello';
            $this->map->set($key, 'World');
            $this->assertTrue($this->map->has($key));
            $this->map->remove($key);
            $this->assertFalse($this->map->has($key));
        }

        public function testGetIteratorWorks()
        {
            $this->map->set('Hello', 'World');
            $iterator = $this->map->getIterator();
            $this->assertInstanceOf('\ArrayIterator', $iterator);
            $this->assertEquals(1, $iterator->count());
        }

        /**
         * @expectedException \phpsolr\MapException
         * @expectedExceptionMessage Key "iDontExist" not set.
         */
        public function testGetThrowsExceptionWhenKeyDoesNotExist()
        {
            $this->map->get('iDontExist');
        }

    }
}
