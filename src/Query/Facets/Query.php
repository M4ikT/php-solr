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
    class FacetQuery
    {
        /**
         * @var string
         */
        private $name;

        /**
         * @var string
         */
        private $value;

        /**
         * @var string
         */
        private $tag;

        /**
         * @var string
         */
        private $excludes = array();

        /**
         * @param string $name
         */
        public function __construct($name)
        {
            $this->name = $name;
        }

        /**
         * @param string $value
         * @return $this
         */
        public function setValue($value)
        {
            $this->value = $value;
            return $this;
        }

        /**
         * @param string $tag
         */
        public function setTag($tag)
        {
            $this->tag = $tag;
        }


        /**
         * @param string $name
         * @return $this
         */
        public function exclude($name)
        {
            $this->excludes[] = $name;
            return $this;
        }

        /**
         * @param array $excludes
         */
        public function excludes(array $excludes)
        {
            $this->excludes = array_merge($this->excludes, $excludes);
        }

        /**
         * @return string
         */
        public function __toString()
        {
            $name = $this->name;
            $excludes = null;
            $tag = null;
            $prefix = '';

            if (count($this->excludes) > 0) {
                $excludes = 'ex='. implode(',', $this->excludes);
            }

            if ($this->tag) {
                $tag = 'tag=' . $this->tag;
            }

            if ($excludes || $tag) {
                $prefix = '{!' . $excludes . ' ' . $tag . '}';
            }

            return sprintf('%s%s:%s', $prefix, $name, $this->value);
        }
    }
}
