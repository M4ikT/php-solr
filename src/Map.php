<?php

namespace phpsolr
{
    /**
     * @covers \phpsolr\Map
     */
    class Map implements \IteratorAggregate
    {
        /**
         * @var array
         */
        private $data = array();

        /**
         * @return bool
         */
        public function isEmpty()
        {
            return count($this->data) == 0;
        }

        /**
         * @param string $key
         * @param string $value
         */
        public function set($key, $value)
        {
            $this->data[$key] = $value;
        }

        /**
         * @param string $key
         * @return bool
         */
        public function has($key)
        {
            return array_key_exists($key, $this->data);
        }

        /**
         * @param string $key
         */
        public function remove($key)
        {
            if ($this->has($key)) {
                unset($this->data[$key]);
            }
        }

        /**
         * @param $key
         * @return mixed
         * @throws MapException
         */
        public function get($key)
        {
            if ($this->has($key)) {
                return $this->data[$key];
            }

            throw new MapException('Key "' . $key . '" not set.');
        }

        /**
         * @return \ArrayIterator
         */
        public function getIterator()
        {
            return new \ArrayIterator($this->data);
        }
    }
}
