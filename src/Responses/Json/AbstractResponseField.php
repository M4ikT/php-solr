<?php

namespace phpsolr\Responses\json
{
    abstract class AbstractResponseField
    {
        /**
         * @var \stdClass
         */
        private $responseField;

        /**
         * @param \stdClass $responseField
         */
        public function __construct(\stdClass $responseField)
        {
            $this->responseField = $responseField;
        }

        /**
         * @return \stdClass
         */
        protected function getResponseField()
        {
            return $this->responseField;
        }
    }
}
