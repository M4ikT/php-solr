<?php

/**
 * Copyright (c) 2015 Maik Thieme <maik.thieme@gmail.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright notice,
 *     this list of conditions and the following disclaimer in the documentation
 *     and/or other materials provided with the distribution.
 *
 *   * Neither the name of Maik Thieme nor the names of contributors
 *     may be used to endorse or promote products derived from this software
 *     without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT  * NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER ORCONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace phpsolr\queries
{
    use phpsolr\Map;
    use phpsolr\queries\facets\Facets;
    use phpsolr\queries\stats\Stats;
    use phpsolr\QueryException;

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
        public function asString()
        {
            $qs = http_build_query($this->getRaw(), null, '&');
            $qs = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $qs);

            return $qs;
        }

        public function getRaw()
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
                $params = array_merge($params, $this->getStats()->getParameters());
            }

            $params = array_merge($params, iterator_to_array($this->getDisMax()->getIterator()));

            return $params;
        }
    }
}
