<?php

namespace phpsolr
{
    use phpsolr\queries\Query;
    use phpsolr\Responses\AbstractResponse;
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
            }

            if ($response->hasError()) {
                throw new ResponseException((string) $response->getError());
            }

            $this->query->setResponse($response);

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
