<?php

namespace phpsolr\Responses\json
{
    class FacetCounts extends AbstractResponseField
    {
        /**
         * @var array
         */
        private $fields = array();

        /**
         * @param array $responseField
         */
        public function __construct(array $responseField)
        {
            parent::__construct($responseField);
            $this->init();
        }

        /**
         * @return bool
         */
        public function hasFields()
        {
            return count($this->fields) > 0;
        }

        /**
         * @param string $key
         * @return bool
         */
        public function hasField($key)
        {
            $this->init();
            return isset($this->fields[$key]);
        }

        /**
         * @return FacetField[]
         */
        public function getFields()
        {
            $this->init();
            return $this->fields;
        }

        /**
         * @param string $key
         * @return FacetField
         */
        public function getField($key)
        {
            $this->init();
            return $this->fields[$key];
        }

        private function init()
        {
            if (count($this->fields) > 0) {
                return;
            }

            foreach ($this->getResponseField()['facet_fields'] as $field => $values) {
                $this->fields[$field] = new FacetField($field, $values);
            }
        }
    }
}
