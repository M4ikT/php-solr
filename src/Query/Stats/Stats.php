<?php

namespace phpsolr\queries\stats
{
    class Stats
    {
        /**
         * @var array
         */
        private $fields = array();

        /**
         * @param string $name
         * @return Field
         */
        public function createField($name)
        {
            $field = new Field($name);

            $this->fields[$name] = $field;
            return $field;
        }

        /**
         * @param array $fields
         */
        public function setFields(array $fields)
        {
            $this->fields = array_merge($fields, $this->fields);
        }

        /**
         * @return bool
         */
        public function hasParameters()
        {
            return count($this->fields) > 0;
        }

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
