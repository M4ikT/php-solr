<?php

namespace phpsolr\queries\facets
{
    class FacetQuery
    {
        /**
         * @var string
         */
        private $name;

        /**
         * @var string
         */
        private $value;

        /**
         * @var string
         */
        private $tag;

        /**
         * @var string
         */
        private $excludes = array();

        /**
         * @param string $name
         */
        public function __construct($name)
        {
            $this->name = $name;
        }

        /**
         * @param string $value
         * @return $this
         */
        public function setValue($value)
        {
            $this->value = $value;
            return $this;
        }

        /**
         * @param string $tag
         */
        public function setTag($tag)
        {
            $this->tag = $tag;
        }


        /**
         * @param string $name
         * @return $this
         */
        public function exclude($name)
        {
            $this->excludes[] = $name;
            return $this;
        }

        /**
         * @param array $excludes
         */
        public function excludes(array $excludes)
        {
            $this->excludes = array_merge($this->excludes, $excludes);
        }

        /**
         * @return string
         */
        public function __toString()
        {
            $name = $this->name;
            $excludes = null;
            $tag = null;
            $prefix = '';

            if (count($this->excludes) > 0) {
                $excludes = 'ex='. implode(',', $this->excludes);
            }

            if ($this->tag) {
                $tag = 'tag=' . $this->tag;
            }

            if ($excludes || $tag) {
                $prefix = '{!' . $excludes . ' ' . $tag . '}';
            }

            return sprintf('%s%s:%s', $prefix, $name, $this->value);
        }
    }
}
