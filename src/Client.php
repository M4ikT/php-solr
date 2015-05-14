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
         * @return AbstractResponse
         */
        public function executeQuery()
        {
            if ($this->query === null) {
                throw new ResponseException('no query defined');
            }

            $response = $this->getCurl()->execute(
                $this->getUri() . '/' . $this->configuration->getRequestHandler() . '?' . (string) $this->query,
                $this->configuration->toCurlOptions()
            );

            switch ($this->query->getResponseFormat()) {
                case 'json':
                    $response = new JsonResponse($response);
                    break;
            }

//            echo '<pre>';var_dump(file_put_contents('/tmp/response.txt', var_export(json_decode($response->getRaw(), true), true)));die;

            if ($response->hasError()) {
                throw new ResponseException((string) $response->getError());
            }

            $this->query->setResponse($response);

            return $response;
            // errorhandling
            // "{"error":{"msg":"For input string: \"lol\"","trace":"java.lang.NumberFormatException: For input string: \"lol\"
        }

        /**
         * @return Curl
         */
        private function getCurl()
        {
            $curl = new Curl;
            return $curl;
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
