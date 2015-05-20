<?php
namespace phpsolr\Responses
{
    use phpsolr\Responses\json\Documents;
    use phpsolr\Responses\json\Error;
    use phpsolr\Responses\json\FacetCounts;
    use phpsolr\Responses\json\ResponseHeader;

    class JsonResponse extends AbstractResponse implements \IteratorAggregate
    {
        /**
         * @param \stdClass $response
         */
        public function __construct($response)
        {
            $this->setResponse(json_decode($response, true));
            $this->setRaw($response);
        }

        /**
         * @return string
         * @throws ResponseException
         */
        public function getNumFound()
        {
            return $this->getResponse()['response']['numFound'];
        }

        /**
         * @return ResponseHeaderInterface
         * @throws ResponseException
         */
        public function getResponseHeader()
        {
            if (isset($this->getResponse()->responseHeader) === false) {
                $message = 'No responseHeader was given.';

                if ($this->getQuery()->isHeaderDisabled()) {
                    $message .= ' Don\'t use omitHeader!';
                }

                throw new ResponseException($message);
            }

            return new ResponseHeader($this->getResponse()->responseHeader);
        }

        /**
         * @return FacetCounts
         */
        public function getFacetCounts()
        {
            return new FacetCounts($this->getResponse()->facet_counts);
        }

        /**
         * @return Documents
         */
        public function getDocuments()
        {
            return new Documents($this->getResponse()['response']['docs']);
        }

        /**
         * @return \ArrayIterator
         */
        public function getIterator()
        {
            return new \ArrayIterator($this->getDocuments());
        }

        /**
         * @return bool
         */
        public function hasError()
        {
            return isset($this->getResponse()->error);
        }

        /**
         * @return Error
         * @throws ResponseException
         */
        public function getError()
        {
            if (!$this->hasError()) {
                throw new ResponseException('no error was from solr given!');
            }

            return new Error($this->getResponse()->error);
        }

        /**
         * @return mixed
         */
        public function getSpellCheck()
        {
            return $this->getResponse()['spellcheck'];
        }
    }
}
