<?php

namespace phpsolr\Responses
{
    abstract class AbstractDocument
    {
        abstract public function __get($name);
    }
}
