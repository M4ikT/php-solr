<?php

namespace phpsolr\queries\facets
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
        private $excludedFields = array();

        /**
         * @param string $name
         */
        public function __construct($name)
        {
            $this->name = $name;
        }

        /**
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param $facetField
         * @return $this
         */
        public function addExclude($facetField)
        {
            $this->excludedFields[] = $facetField;
            return $this;
        }

        /**
         * @param array $facetFields
         * @return $this
         */
        public function addExcludes(array $facetFields)
        {
            $this->excludedFields = array_merge($this->excludedFields, $facetFields);
            return $this;
        }

        /**
         * @param string $key
         * @return $this
         */
        public function setKey($key)
        {
            $this->key = $key;
            return $this;
        }

        /**
         * @return string
         */
        public function getKey()
        {
            if ($this->key) {
                return $this->key;
            }

            return $this->name;
        }

        /**
         * @return string
         * @throws \phpsolr\MapException
         */
        public function __toString()
        {
            $name = $this->name;;
            $key = 'key=' . $name;
            $excludedFields = '';

            if ($this->key !== null) {
                $key = 'key=' . $this->key;
            }

            foreach ($this->excludedFields as $field) {
                $excludedFields .= 'ex=' . $field . ' ';
            }

            return sprintf('{!%s%s}%s', $excludedFields, $key, $name);
        }
    }
}



