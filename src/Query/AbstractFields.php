<?php

namespace phpsolr\queries\stats
{
    abstract class AbstractFields
    {
        /**
         * @var array
         */
        protected $fields = array();

        /**
         * @var array
         */
        private $fieldsByKeys = array();

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
         * @param Field[] $fields
         */
        public function setFields(array $fields)
        {
            foreach ($fields as $field) {
                if (!$field instanceof Field) {
                    continue;
                }

                $this->fields[$field->getName()] = $field;
            }
        }

        /**
         * @return bool
         */
        public function hasParameters()
        {
            return count($this->fields) > 0;
        }

        abstract public function getParameters();

        /**
         * @return Field[]
         */
        public function getFields()
        {
            foreach ($this->fields as $field) {
                $this->fieldsByKeys[$field->getKey()] = $field;
            }

            return $this->fieldsByKeys;
        }
    }
}