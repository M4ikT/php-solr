<?php

namespace phpsolr\Responses\json
{
    class SpellCheck
    {
        /**
         * @var array
         */
        private $response;

        /**
         * @param array $response
         */
        public function __construct(array $response)
        {
            $spellcheck = array();

            if (isset($response['spellcheck'])) {
                $spellcheck = $response['spellcheck'];
            }

            $this->response = $spellcheck;
        }

        /**
         * @return bool
         */
        public function hasCollations()
        {
            //poc
            return false;
        }
    }
}
