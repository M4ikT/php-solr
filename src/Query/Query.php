<?php

namespace phpsolr\queries
{
    use phpsolr\Map;
    use phpsolr\queries\facets\Facets;
    use phpsolr\queries\stats\Stats;
    use phpsolr\QueryException;
    use phpsolr\Responses\AbstractResponse;

    class Query extends Map
    {
        /**
         * @var string
         */
        private $requestHandler;

        /**
         * @var array
         */
        private $allowedResponseFormats = array(
            'json',
        );

        /**
         * @var AbstractResponse
         */
        private $response;

        /**
         * @var Stats
         */
        private $statsQuery;

        /**
         * @var Facets
         */
        private $facets;

        /**
         * @var DisMax
         */
        private $disMax;

        /**
         * @return bool
         */
        public function isHeaderDisabled()
        {
            return $this->has('omitHeader');
        }

        public function omitHeader()
        {
            $this->set('omitHeader', 'true');
        }

        /**
         * @param string $format
         * @throws QueryException
         */
        public function setResponseFormat($format)
        {
            if (in_array($format, $this->allowedResponseFormats) === false) {
                throw new QueryException('Format "' . $format . '" are not supported!');
            }

            $this->set('wt', $format);
        }

        /**
         * @param string $query
         */
        public function setQueryString($query)
        {
            if ($query !== '*:*') {
                $query = $this->escape($query);
            }

            $this->set('q', $query);
        }

        public function hasRequestHandler()
        {
            return $this->requestHandler !== null;
        }

        /**
         * @param string $handler
         */
        public function setRequestHandler($handler)
        {
            $this->requestHandler = $handler;
        }

        /**
         * @return bool
         */
        public function getRequestHandler()
        {
            return $this->requestHandler;
        }

        /**
         * @param string $fieldName
         * @param string $direction | asc desc
         */
        public function sortBy($fieldName, $direction)
        {
            $this->set('sort', $fieldName . ' ' . $direction);
        }

        /**
         * @param string $value
         * @return string
         */
        public function escape($value)
        {
            $pattern = '/(\+|-|&&|\|\||!|\(|\)|\{|}|\[|]|\^|"|~|\*|\?|:|\\\)/';
            $replace = '\\\$1';

            return preg_replace($pattern, $replace, $value);
        }

        /**
         * @param string $start
         */
        public function setStart($start)
        {
            $this->set('start', $start);
        }

        /**
         * @param string $rows
         */
        public function setRows($rows)
        {
            $this->set('rows', $rows);
        }

        /**
         * @param AbstractResponse $response
         */
        public function setResponse(AbstractResponse $response)
        {
            $this->response = $response;
            $response->setQuery($this);
        }

        /**
         * @return AbstractResponse
         */
        public function getResponse()
        {
            if (!$this->response instanceof AbstractResponse) {
                // exception
            }

            return $this->response;
        }

        /**
         * @return mixed
         * @throws \phpsolr\MapException
         */
        public function getResponseFormat()
        {
            return $this->get('wt');
        }

        /**
         * @param array $fields
         */
        public function setFields(array $fields)
        {
            $this->set('fl', implode(',', $fields));
        }

        /**
         * @param string $field
         */
        public function setField($field)
        {
            if ($this->has('fl')) {
                $this->set('fl', $this->get('fl') . ',' . $field);
                return;
            }

            $this->set('fl', $field);
        }

        /**
         * @return Facets
         */
        public function getFacets()
        {
            if ($this->facets === null) {
                $this->facets = new Facets;
            }

            return $this->facets;
        }

        /**
         * @return Stats
         */
        public function getStats()
        {
            if ($this->statsQuery === null) {
                $this->statsQuery = new Stats;
            }

            return $this->statsQuery;
        }

        /**
         * @return DisMax
         */
        public function getDisMax()
        {
            if ($this->disMax === null) {
                $this->disMax = new DisMax;
            }

            return $this->disMax;
        }

        /**
         * @return string
         */
        public function __toString()
        {
            if (!$this->has('wt')) {
                $this->set('wt', 'json');
            }

            $params = array();
            $params = array_merge(iterator_to_array($this->getIterator()), $params);

            if ($this->getFacets()->hasParameters()) {
                $params = array_merge(array('facet' => 'true'), $params);
            }

            $params = array_merge($params, $this->getFacets()->getParameters());

            if ($this->getStats()->hasParameters()) {
                $params = array_merge(array('stats' => 'true'), $params);
            }

            $params = array_merge($params, $this->getStats()->getParameters());
            $params = array_merge($params, iterator_to_array($this->getDisMax()->getIterator()));

            $qs = http_build_query($params, null, '&');
            $qs = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $qs);


            return $qs;
        }
    }
}
