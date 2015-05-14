<?php

namespace phpsolr
{
    require __DIR__ . '/src/autoload.php';

//    $client = new Client(new Configuration(array('host' => 'localhost', 'path' => '/solr/products/', 'requestHandler' => 'storesearch')));
    $client = new Client(new Configuration(array('host' => 'devsl02.dmz2.corp.competec.ch', 'path' => '/solr/brack_ch-products_shard1_replica1/')));

    $query = $client->getQuery();

    $query->setQueryString('*:*');
    $query->omitHeader();
    $query->setRows('5');
    $query->setStart('50');
    $query->setFields(array('name', 'sku'));

    $fq = $query->getFilterQuery();
    $fq->createField('attributeGroup_backplane')->setKey('attributeGroup_backplane');
//    $query->setField('name');

    $client->executeQuery();

//    var_dump($query->getResponse()->getError());

//    foreach ($query->getResponse()->getFacetCounts()->getFields() as $field) {
//        var_dump($field);die;
//    }
//
//    foreach ($query->getResponse() as $document) {
//        var_dump($document);
//    }
}
