<?php

namespace phpsolr\Responses\json
{
    abstract class AbstractResponseField
    {
        /**
         * @var array
         */
        private $responseField;

        /**
         * @param array $responseField
         */
        public function __construct(array $responseField)
        {
            $this->responseField = $responseField;
        }

        /**
         * @return array
         */
        protected function getResponseField()
        {
            return $this->responseField;
        }
    }
}
