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

namespace phpsolr
{
    class Curl
    {
        /**
         * @var array
         */
        private $options;

        /**
         * @var array
         */
        private $curlInfo;

        /**
         * @param array $options
         */
        public function __construct(array $options = array())
        {
            $this->options = $options;
        }

        /**
         * @param string $url
         * @param array $options
         * @return mixed
         * @throws \RuntimeException
         */
        public function execute($url, array $options = array())
        {
            $curl = curl_init();
            curl_setopt_array($curl, $this->fetchOptions($url, $options));
            $result = curl_exec($curl);

            if (curl_errno($curl)) {
                $error = curl_error($curl);
                $errorNumber = curl_errno($curl);
                curl_close($curl);
                throw new \RuntimeException('Curl Error "' . $error . '" with ErrorCode "' . $errorNumber . '"');
            }

            $this->curlInfo = curl_getinfo($curl);

            curl_close($curl);

            return $result;
        }

        /**
         * @param string $url
         * @param string $options
         * @return array
         */
        private function fetchOptions($url, $options)
        {
            if (!isset($options[CURLOPT_RETURNTRANSFER])) {
                $options[CURLOPT_RETURNTRANSFER] = true;
            }

            if (!isset($options[CURLOPT_CONNECTTIMEOUT_MS])) {
                $options[CURLOPT_TIMEOUT_MS] = 1000;
                $options[CURLOPT_CONNECTTIMEOUT_MS] = 1000;
            }

            $options[CURLOPT_URL] = $url;
            $options[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;

            return array_replace($this->options, $options);
        }
    }
}
