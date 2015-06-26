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



