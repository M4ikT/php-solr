<?php

namespace phpsolr\Responses
{
    use phpsolr\queries\Query;

    abstract class AbstractResponse
    {
        /**
         * @var Query
         */
        private $query;

        private $response;

        /**
         * @var string
         */
        private $raw;

        /**
         * @param Query $query
         */
        public function setQuery(Query $query)
        {
            $this->query = $query;
        }

        /**
         * @return Query
         */
        public function getQuery()
        {
            return $this->query;
        }

        /**
         * @param $response
         */
        protected function setResponse($response)
        {
            $this->response = $response;
        }

        protected function getResponse()
        {
            return $this->response;
        }

        /**
         * @param string $raw
         */
        protected function setRaw($raw)
        {
            $this->raw = $raw;
        }

        /**
         * @return string
         */
        public function getRaw()
        {
            return $this->raw;
        }

        abstract public function getDocuments();
        abstract public function getFacetCounts();
        abstract public function getSpellCheck();
        abstract public function getNumFound();

        /**
         * @return ResponseHeaderInterface
         */
        abstract public function getResponseHeader();
    }
}
