<?php

namespace phpsolr\Responses\json
{
    abstract class AbstractField
    {
        /**
         * @var string
         */
        private $name;

        /**
         * @var string
         */
        private $key;

        /**
         * @var array
         */
        protected $values;

        /**
         * @param string $name
         * @param string $key
         * @param array $values
         */
        public function __construct($name, $key, array $values)
        {
            $this->name = $name;
            $this->key = $key;
            $this->initValues($values);
        }

        /**
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @return string
         */
        public function getKey()
        {
            return $this->key;
        }

        /**
         * @return array
         */
        protected function getValues()
        {
            return $this->values;
        }

        /**
         * @param array $values
         */
        abstract protected function initValues(array $values);
    }
}
