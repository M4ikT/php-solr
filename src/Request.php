<?php

namespace phpsolr
{
    class Request
    {
        /**
         * @var SpellCheck
         */
        private $query;

        /**
         * @var SpellCheck
         */
        private $spellCheck;

        /**
         * @var Updater
         */
        private $updater;

        public function __construct()
        {

        }

        /**
         * @return Query
         */
        public function getQuery()
        {
            if ($this->query === null) {
                $this->query = new Query;
            }

            return $this->query;
        }

        /**
         * @return SpellCheck
         */
        public function getSpellCheck()
        {
            if ($this->spellCheck === null) {
                $this->spellCheck = new SpellCheck;
            }

            return $this->spellCheck;
        }

        /**
         * @return Updater
         */
        public function getUpdater()
        {
            if ($this->updater === null) {
                $this->updater = new Updater;
            }

            return $this->updater;
        }
    }
}
