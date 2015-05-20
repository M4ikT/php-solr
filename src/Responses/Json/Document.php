<?php

namespace phpsolr\Responses\json
{
    use phpsolr\Responses\AbstractDocument;

    class Document extends AbstractDocument
    {
        /**
         * @var array
         */
        private $document;

        /**
         * @param array $document
         */
        public function __construct(array $document)
        {
            $this->document = $document;
        }

        /**
         * @param string $name
         * @return string
         */
        public function __get($name)
        {
            if (!isset($this->document[$name])) {
                throw new \InvalidArgumentException('property "' . $name . '" not found');
            }

            return $this->document[$name];
        }
    }
}
