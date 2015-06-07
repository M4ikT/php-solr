<?php

namespace phpsolr\queries\stats
{
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
