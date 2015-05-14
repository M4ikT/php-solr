<?php

namespace phpsolr
{
    class Curl
    {
        /**
         * @var array
         */
        private $options;

        /**
         * @var array
         */
        private $curlInfo;

        /**
         * @param array $options
         */
        public function __construct(array $options = array())
        {
            $this->options = $options;
        }

        /**
         * @param string $url
         * @param array $options
         * @return mixed
         * @throws \RuntimeException
         */
        public function execute($url, array $options = array())
        {
            $curl = curl_init();
            curl_setopt_array($curl, $this->fetchOptions($url, $options));
            $result = curl_exec($curl);

            if (curl_errno($curl)) {
                $error = curl_error($curl);
                $errorNumber = curl_errno($curl);
                curl_close($curl);
                throw new \RuntimeException('Curl Error "' . $error . '" with ErrorCode "' . $errorNumber . '"');
            }

            $this->curlInfo = curl_getinfo($curl);

            curl_close($curl);

            return $result;
        }

        public function getInfo()
        {
            if ($this->curlInfo === null) {
                throw new \LogicException('Call execute first');
            }

            return $this->curlInfo;
        }

        /**
         * @param string $url
         * @param string $options
         * @return array
         */
        private function fetchOptions($url, $options)
        {
            if (!isset($options[CURLOPT_RETURNTRANSFER])) {
                $options[CURLOPT_RETURNTRANSFER] = true;
            }

            if (!isset($options[CURLOPT_CONNECTTIMEOUT_MS])) {
                $options[CURLOPT_TIMEOUT_MS] = 1000;
                $options[CURLOPT_CONNECTTIMEOUT_MS] = 1000;
            }

            $options[CURLOPT_URL] = $url;
            $options[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;

            return array_replace($this->options, $options);
        }
    }
}
