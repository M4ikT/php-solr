<?php

namespace phpsolr\queries\facets
{
    class Query
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
         * @return $this
         */
        public function excludeTag($tag)
        {
            $this->tag = $tag;
            return $this;
        }

        /**
         * @return string
         */
        public function __toString()
        {
            $name = $this->name;;
            $tag = '';

            if ($this->tag !== null) {
                $tag = '{!tag=' . $this->tag . '}';
            }

            return sprintf('%s%s:%s', $tag, $name, $this->value);
        }
    }
}
