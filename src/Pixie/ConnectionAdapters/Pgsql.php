<?php namespace Pixie\ConnectionAdapters;

class Pgsql extends ConnectionAdapter
{
    /**
     * @param $config
     *
     * @return mixed
     */
    public function connect($config)
    {
        $connectionString = "pgsql:host={$config['host']};dbname={$config['database']}";

        if (isset($config['port'])) {
            $connectionString .= ";port={$config['port']}";
        }

        $connection = $this->container->build(
            '\PDO',
            array($connectionString, $config['username'], $config['password'])
        );

        if (isset($config['charset'])) {
            $connection->prepare("SET NAMES '{$config['charset']}'")->execute();
        }

        if (isset($config['schema'])) {
            $connection->prepare("SET search_path TO '{$config['schema']}'")->execute();
        }

        return $connection;
    }
}