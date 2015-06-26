<?php

namespace phpsolr\Responses\json
{
    use competec\Library\ValueObjects\Uri;

    class StatsField extends AbstractField
    {
        /**
         * @return double
         */
        public function getMin()
        {
            return (int) $this->getValues()['min'];
        }

        /**
         * @return double
         */
        public function getMax()
        {
            return (int) $this->getValues()['max'];
        }

        /**
         * @return int
         */
        public function getCount()
        {
            return (int) $this->getValues()['count'];
        }

        /**
         * @param Uri $uri
         * @return string
         */
        public function createMinSelectedValue(Uri $uri)
        {
            $min = $this->getMin();
            $max = $this->getMax();

            if (!isset($uri->getParameters()['filter'][$this->getName()])) {
                return $min;
            }

            $values = explode(' - ', $uri->getParameters()['filter'][$this->getName()][0]);
            $selectedMin = $values[0];

            if (!isset($values[1])) {
                $values[1] = $max;
            }

            if ($selectedMin >= $min && $selectedMin <= $max && $selectedMin <= $values[1]) {
                return $selectedMin;
            }

            return $min;
        }

        /**
         * @param Uri $uri
         * @return string
         */
        public function createMaxSelectedValue(Uri $uri)
        {
            $min = $this->getMin();
            $max = $this->getMax();

            if (!isset($uri->getParameters()['filter'][$this->getName()])) {
                return $max;
            }

            $values = explode(' - ', $uri->getParameters()['filter'][$this->getName()][0]);

            if (!isset($values[1])) {
                return $max;
            }

            $selectedMax = $values[1];
            if ($selectedMax <= $max && $selectedMax >= $min && $selectedMax >= $values[0]) {
                return $selectedMax;
            }

            return $max;
        }

        /**
         * @param array $values
         */
        protected function initValues(array $values)
        {
            $this->values = $values;
        }

        /**
         * @return Value[]
         */
        public function getValues()
        {
            return $this->values;
        }
    }
}
