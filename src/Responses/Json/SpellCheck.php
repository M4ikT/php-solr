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
         * @var array
         */
        private $collations = array();

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
            return isset($this->response['suggestions'][1]['numFound'])
                && $this->response['suggestions'][1]['numFound'] > 0;
        }

        /**
         * @return CollationQuery[]
         * @throws SpellCheckException
         */
        public function getCollationQueries()
        {
            if (!$this->hasCollations()) {
                throw new SpellCheckException();
            }

            foreach ($this->response['suggestions'] as $value) {
                if (!is_array($value) || !isset($value[0])) {
                    continue;
                }

                $this->collations[] = new CollationQuery($value);
            }

            return $this->collations;
        }
    }
}
