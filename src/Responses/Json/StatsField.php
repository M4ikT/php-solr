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
    use competec\Library\ValueObjects\Uri;

    class StatsField extends AbstractField
    {
        /**
         * @return string
         */
        public function getMin()
        {
            return $this->getValues()['min'];
        }

        /**
         * @return string
         */
        public function getMax()
        {
            return $this->getValues()['max'];
        }

        /**
         * @return int
         */
        public function getCount()
        {
            return (int) $this->getValues()['count'];
        }

        /**
         * @param Uri $uri
         * @return string
         */
        public function createMinSelectedValue(Uri $uri)
        {
            $min = $this->getMin();
            $max = $this->getMax();

            if (!isset($uri->getParameters()['filter'][$this->getName()])) {
                return $min;
            }

            $values = explode(' - ', $uri->getParameters()['filter'][$this->getName()][0]);
            $selectedMin = $values[0];

            if (!isset($values[1])) {
                $values[1] = $max;
            }

            if ($selectedMin >= $min && $selectedMin <= $max && $selectedMin <= $values[1]) {
                return $selectedMin;
            }

            return $min;
        }

        /**
         * @param Uri $uri
         * @return string
         */
        public function createMaxSelectedValue(Uri $uri)
        {
            $min = $this->getMin();
            $max = $this->getMax();

            if (!isset($uri->getParameters()['filter'][$this->getName()])) {
                return $max;
            }

            $values = explode(' - ', $uri->getParameters()['filter'][$this->getName()][0]);

            if (!isset($values[1])) {
                return $max;
            }

            $selectedMax = $values[1];
            if ($selectedMax <= $max && $selectedMax >= $min && $selectedMax >= $values[0]) {
                return $selectedMax;
            }

            return $max;
        }

        /**
         * @param array $values
         */
        protected function initValues(array $values)
        {
            $this->values = $values;
        }

        /**
         * @return Value[]
         */
        public function getValues()
        {
            return $this->values;
        }
    }
}
