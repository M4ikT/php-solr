<?php

namespace phpsolr\Responses\json
{
    use phpsolr\queries\Query;

    class Stats extends AbstractResponseField
    {
        /**
         * @var array
         */
        private $fields = array();

        /**
         * @var Query
         */
        private $query;

        /**
         * @param array $responseField
         * @param Query $query
         */
        public function __construct(array $responseField, Query $query)
        {
            parent::__construct($responseField);
            $this->query = $query;

            $this->init();
        }

        /**
         * @return bool
         */
        public function hasFields()
        {
            return count($this->fields) > 0;
        }

        /**
         * @param string $key
         * @return bool
         */
        public function hasField($key)
        {
            $this->init();
            return isset($this->fields[$key]);
        }

        /**
         * @return FacetField[]
         */
        public function getFields()
        {
            $this->init();
            return $this->fields;
        }

        /**
         * @param string $key
         * @return FacetField
         */
        public function getField($key)
        {
            $this->init();
            return $this->fields[$key];
        }

        private function init()
        {
            if (count($this->fields) > 0) {
                return;
            }

            $fields = $this->query->getStats()->getFields();

            foreach ($this->getResponseField()['stats_fields'] as $field => $values) {
                $key = $field;

                if (isset($fields[$field])) {
                    $key = $fields[$field]->getKey();
                }

                $this->fields[$field] = new StatsField($fields[$field]->getName(), $key, $values);
            }
        }
    }
}
