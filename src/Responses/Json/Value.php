<?php

namespace phpsolr\Responses\json
{
    class Value
    {
        /**
         * @var string
         */
        private $value;

        /**
         * @var string
         */
        private $numFound;

        /**
         * @param string $value
         * @param string $numFound
         */
        public function __construct($value, $numFound)
        {
            $this->value = $value;
            $this->numFound = $numFound;
        }

        /**
         * @return string
         */
        public function getValue()
        {
            return $this->value;
        }

        /**
         * @return string
         */
        public function getNumFound()
        {
            return $this->numFound;
        }
    }
}
