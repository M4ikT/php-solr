<?php

namespace phpsolr\Responses\json
{
    class CollationQuery
    {
        /**
         * @var array
         */
        private $collation = array();

        /**
         * @param array $collation
         */
        public function __construct(array $collation)
        {
            $this->init($collation);
        }

        /**
         * @return int
         */
        public function getNumFound()
        {
            return $this->collation['hits'];
        }

        /**
         * @return string
         */
        public function getQuery()
        {
            return $this->collation['collationQuery'];
        }

        /**
         * @param array $collation
         */
        private function init(array $collation)
        {
            for ($i = 0; $i < count($collation); $i++) {
                $this->collation[$collation[$i]] = $collation[$i += 1];
            }
        }
    }
}
