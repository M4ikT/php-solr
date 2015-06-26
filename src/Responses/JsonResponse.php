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

namespace phpsolr\Responses
{
    use phpsolr\Responses\json\Documents;
    use phpsolr\Responses\json\Error;
    use phpsolr\Responses\json\FacetCounts;
    use phpsolr\Responses\json\ResponseHeader;
    use phpsolr\Responses\json\SpellCheck;
    use phpsolr\Responses\json\Stats;

    class JsonResponse extends AbstractResponse implements \IteratorAggregate
    {
        private $spellCheck;
        private $facetCounts;

        /**
         * @param \stdClass $response
         */
        public function __construct($response)
        {
            $this->setResponse(json_decode($response, true));
            $this->setRaw($response);
        }

        /**
         * @return string
         * @throws ResponseException
         */
        public function getNumFound()
        {
            return $this->getResponse()['response']['numFound'];
        }

        /**
         * @return ResponseHeaderInterface
         * @throws ResponseException
         */
        public function getResponseHeader()
        {
            if (isset($this->getResponse()->responseHeader) === false) {
                $message = 'No responseHeader was given.';

                if ($this->getQuery()->isHeaderDisabled()) {
                    $message .= ' Don\'t use omitHeader!';
                }

                throw new ResponseException($message);
            }

            return new ResponseHeader($this->getResponse()->responseHeader);
        }

        /**
         * @return FacetCounts
         */
        public function getFacetCounts()
        {
            if ($this->facetCounts === null) {
                $this->facetCounts = new FacetCounts($this->getResponse()['facet_counts'], $this->getQuery());
            }

            return $this->facetCounts;
        }

        /**
         * @return Documents
         */
        public function getDocuments()
        {
            return new Documents($this->getResponse()['response']['docs']);
        }

        /**
         * @return \ArrayIterator
         */
        public function getIterator()
        {
            return new \ArrayIterator($this->getDocuments());
        }

        /**
         * @return bool
         */
        public function hasError()
        {
            return isset($this->getResponse()->error);
        }

        /**
         * @return Error
         * @throws ResponseException
         */
        public function getError()
        {
            if (!$this->hasError()) {
                throw new ResponseException('no error was from solr given!');
            }

            return new Error($this->getResponse()->error);
        }

        /**
         * @return mixed
         */
        public function getSpellCheck()
        {
            if ($this->spellCheck === null) {
                return new SpellCheck($this->getResponse());
            }

            return $this->spellCheck;
        }

        /**
         * @return Stats
         */
        public function getStats()
        {
            if ($this->spellCheck === null) {
                return new Stats($this->getResponse()['stats'], $this->getQuery());
            }

            return $this->spellCheck;
        }
    }
}
