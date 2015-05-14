<?php

namespace phpsolr\queries
{
    use phpsolr\Map;

    class DisMax extends Map
    {
        public function __construct()
        {
            $this->set('defType', 'dismax');
        }

        /**
         * @param string $mm
         */
        public function setMinimumShouldMatch($mm)
        {
            $this->set('mm', $mm);
        }
    }
}
