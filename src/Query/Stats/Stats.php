<?php

namespace phpsolr\queries\stats
{
    use phpsolr\queries\facets\AbstractFields;

    class Stats extends AbstractFields
    {
        /**
         * @return array
         */
        public function getParameters()
        {
            $fields = array();

            foreach ($this->fields as $field) {
                $fields['stats.field'][] = (string) $field;
            }

            return $fields;
        }
    }
}
