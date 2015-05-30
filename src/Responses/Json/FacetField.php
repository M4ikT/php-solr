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
         * @param string $name
         * @param array $values
         */
        public function __construct($name, array $values)
        {
            $this->name = $name;
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
