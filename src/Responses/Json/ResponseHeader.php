<?php

namespace phpsolr\Responses\json
{
    class ResponseHeader
    {
        /**
         * @var \stdClass
         */
        private $response;

        /**
         * @param \stdClass $response
         */
        public function __construct(\stdClass $response)
        {
            $this->response = $response;
        }

        /**
         * @return string
         */
        public function getNumFound()
        {
            return $this->response->numFound;
        }
    }
}
