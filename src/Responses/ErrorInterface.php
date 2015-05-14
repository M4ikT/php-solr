<?php

namespace phpsolr\Responses
{
    interface ErrorInterface
    {
        public function getCode();
        public function getMessage();
    }
}
