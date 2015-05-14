<?php

namespace phpsolr\Responses\json
{
    use phpsolr\Responses\ErrorInterface;

    class Error extends AbstractResponseField implements ErrorInterface
    {
        /**
         * @return string
         */
        public function getCode()
        {
            return $this->getResponseField()->code;
        }

        /**
         * @return string
         */
        public function getMessage()
        {
            return $this->getResponseField()->msg;
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return 'Error: ' . $this->getMessage() . '. Code: ' . $this->getCode();
        }
    }
}
