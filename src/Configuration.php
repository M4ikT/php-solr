<?php

namespace phpsolr
{
    class Configuration
    {
        /**
         * @var array
         */
        private $config = array(
            'scheme' => 'http',
            'port' => '8983',
            'requestHandler' => 'select',
            'header' => 'application/json',
            'timeOut' => '5000',
        );

        /**
         * @var array
         */
        private $requiredConfigParameters = array(
            'host',
            'path',
        );

        /**
         * @param array $config
         * @throws ConfigurationException
         */
        public function __construct(array $config)
        {
            $this->validate($config);
            $this->config = array_replace($this->config, $config);
        }

        /**
         * @param array $config
         * @throws ConfigurationException
         */
        private function validate(array $config)
        {
            $missedParameters = array();

            foreach ($this->requiredConfigParameters as $requiredParameter) {
                if (isset($config[$requiredParameter]) !== false) {
                    continue;
                }

                $missedParameters[] = $requiredParameter;
            }

            if (count($missedParameters) > 0) {
                throw new ConfigurationException('configuration params missed: "' . implode(', ', $missedParameters) . '"');
            }
        }

        /**
         * @return string
         * @throws ConfigurationException
         */
        public function getScheme()
        {
            return $this->get('scheme');
        }

        /**
         * @return string
         * @throws ConfigurationException
         */
        public function getHost()
        {
            return $this->get('host');
        }

        /**
         * @return string
         * @throws ConfigurationException
         */
        public function getPort()
        {
            return $this->get('port');
        }

        /**
         * @return string
         * @throws ConfigurationException
         */
        public function getPath()
        {
            return $this->get('path');
        }

        /**
         * @return string
         * @throws ConfigurationException
         */
        public function getRequestHandler()
        {
            return $this->get('requestHandler');
        }

        /**
         * @return array
         * @throws ConfigurationException
         */
        public function toCurlOptions()
        {
            $options = array();

            if ($this->has('username') && $this->has('password')) {
                $options[CURLOPT_USERPWD] = $this->get('username') . ':' . $this->get('password');
            }

            $options[CURLOPT_TIMEOUT_MS] = $this->config['timeOut'];
            $options[CURLOPT_CONNECTTIMEOUT_MS] = $this->config['timeOut'];
            $options[CURLOPT_HTTPHEADER] = array('Content-Type: application/json');

            return $options;
        }

        /**
         * @param string $key
         * @return string
         * @throws ConfigurationException
         */
        private function get($key)
        {
            if (isset($this->config[$key]) === false) {
                throw new ConfigurationException('configuration "' . $key . '" not found');
            }

            return $this->config[$key];
        }

        /**
         * @param string $key
         * @return bool
         */
        private function has($key)
        {
            return isset($this->config[$key]);
        }
    }
}
