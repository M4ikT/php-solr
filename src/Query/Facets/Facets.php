<?php

namespace phpsolr\queries\facets
{
    use phpsolr\queries\stats\AbstractFields;

    class Facets extends AbstractFields
    {
        /**
         * @var array
         */
        private $queries = array();

        /**
         * @param string $name
         * @return Query
         */
        public function createQuery($name)
        {
            $query = new Query($name);

            $this->queries[$name] = $query;
            return $query;
        }

        /**
         * @param array $queries
         */
        public function setQueries(array $queries)
        {
            $this->queries = array_merge($queries, $this->queries);
        }

        /**
         * @return bool
         */
        public function hasParameters()
        {
            return parent::hasParameters()
                || count($this->queries) > 0;
        }

        /**
         * @return array
         */
        public function getParameters()
        {
            $fields = array();
            $queries = array();

            foreach ($this->fields as $field) {
                $fields['facet.field'][] = (string) $field;
            }

            foreach ($this->queries as $query) {
                $queries['fq'][] = (string) $query;
            }

            return array_merge($fields, $queries);
        }

        /**
         * @return Query[]
         */
        public function getQueries()
        {
            return $this->queries;
        }
    }
}
