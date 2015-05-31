<?php

namespace phpsolr\Responses\json
{
    class FacetField
    {
        /**
         * @var string
         */
        private $name;

        /**
         * @var Value[]
         */
        private $values;

        /**
         * @var string
         */
        private $key;

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
         * @return bool
         */
        public function hasValues()
        {
            return count($this->values) > 0;
        }

        /**
         * @return Value[]
         */
        public function getValues()
        {
            return $this->values;
        }

        /**
         * @param array $values
         */
        private function initValues(array $values)
        {
            foreach (array_chunk($values, 2) as $splittedValues) {
                $this->values[] = new Value($splittedValues[0], $splittedValues[1]);
            }
        }
    }
}
