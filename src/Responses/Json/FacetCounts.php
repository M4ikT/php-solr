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

namespace phpsolr\Responses\json
{
    use phpsolr\queries\Query;

    class FacetCounts extends AbstractResponseField
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

            $fields = $this->query->getFacets()->getFields();

            foreach ($this->getResponseField()['facet_fields'] as $field => $values) {
                $key = $field;
                $name = $field;

                if (isset($fields[$field])) {
                    $key = $fields[$field]->getKey();
                    $name = $fields[$field]->getName();
                }

                $this->fields[$field] = new FacetField($name, $key, $values);
            }
        }
    }
}
