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
    use phpsolr\queries\Query;
    use phpsolr\Responses\JsonResponse;
    use phpsolr\Responses\ResponseException;

    class Client
    {
        /**
         * @var Query
         */
        private $query;

        /**
         * @var Configuration
         */
        private $configuration;

        /**
         * @param Configuration $configuration
         */
        public function __construct(Configuration $configuration)
        {
            $this->configuration = $configuration;
        }

        /**
         * @return Query
         */
        public function getQuery()
        {
            if ($this->query === null) {
                $this->query = new Query;
            }

            return $this->query;
        }

        /**
         * @return JsonResponse
         * @throws ResponseException
         */
        public function executeQuery()
        {
            if ($this->query === null) {
                throw new ResponseException('no query defined');
            }

            if (!$this->query->hasRequestHandler()) {
                $this->query->setRequestHandler($this->configuration->getRequestHandler());
            }

            $response = $this->getCurl()->execute(
                $this->getUri() . '/' . $this->query->getRequestHandler() . '?' . (string) $this->query,
                $this->configuration->toCurlOptions()
            );

            switch ($this->query->getResponseFormat()) {
                case 'json';
                    $response = new JsonResponse($response);
                    $response->setQuery($this->query);
            }

            if ($response->hasError()) {
                throw new ResponseException((string) $response->getError());
            }

            return $response;
        }

        /**
         * @return Curl
         */
        private function getCurl()
        {
            return new Curl;
        }

        /**
         * @return string
         */
        private function getUri()
        {
            return sprintf(
                '%s://%s:%s%s',
                $this->configuration->getScheme(),
                $this->configuration->getHost(),
                $this->configuration->getPort(),
                $this->configuration->getPath()
            );
        }
    }
}
