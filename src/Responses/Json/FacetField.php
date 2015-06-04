<?php

namespace phpsolr\Responses\json
{
    class FacetField extends AbstractField
    {
        /**
         * @return bool
         */
        public function hasValues()
        {
            return count($this->values) > 0;
        }

        /**
         * @return Value[]
         */
        public function getValues()
        {
            return parent::getValues();
        }

        /**
         * @param array $values
         */
        protected function initValues(array $values)
        {
            foreach (array_chunk($values, 2) as $splittedValues) {
                $this->values[] = new Value($splittedValues[0], $splittedValues[1]);
            }
        }
    }
}
