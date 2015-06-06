<?php

namespace phpsolr
{
    use phpsolr\queries\Query;

    class ClientTest extends \PHPUnit_Framework_TestCase
    {
        private $client;

        protected function setUp()
        {
            $configuration = $this->getMockBuilder(Configuration::class)->disableOriginalConstructor()->getMock();
            $this->client= new Client($configuration);
        }

        public function testGetQueryWorks()
        {
            $this->assertInstanceOf(Query::class, $this->client->getQuery());
        }
    }
}
