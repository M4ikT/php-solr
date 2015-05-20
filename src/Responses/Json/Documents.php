<?php
namespace phpsolr\Responses\json
{
    use phpsolr\Responses\AbstractDocuments;
    use Traversable;

    class Documents extends AbstractDocuments
    {
        /**
         * @var Document[]
         */
        private $documents = array();

        /**
         * @param array $documents
         */
        public function __construct(array $documents)
        {
            $this->init($documents);
        }

        /**
         * @param array $documents
         */
        private function init(array $documents)
        {
            foreach ($documents as $document) {
                $this->documents[] = new Document($document);
            }
        }

        /**
         * (PHP 5 &gt;= 5.1.0)<br/>
         * Count elements of an object
         * @link http://php.net/manual/en/countable.count.php
         * @return int The custom count as an integer.
         * </p>
         * <p>
         * The return value is cast to an integer.
         */
        public function count()
        {
            return count($this->documents);
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Retrieve an external iterator
         * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
         * @return Traversable An instance of an object implementing <b>Iterator</b> or
         * <b>Traversable</b>
         */
        public function getIterator()
        {
            return new \ArrayIterator($this->documents);
        }
    }
}
