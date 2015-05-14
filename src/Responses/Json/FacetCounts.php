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
         * @return bool
         */
        public function hasFields()
        {
            return count($this->fields) > 0;
        }

        /**
         * @return array
         */
        public function getFields()
        {
            if (count($this->fields) > 0) {
                return $this->fields;
            }

            foreach ($this->getResponseField()->facet_fields as $field => $values) {
                $this->fields[] = new FacetField($field, $values);
            }

            return $this->fields;
        }
    }
}
