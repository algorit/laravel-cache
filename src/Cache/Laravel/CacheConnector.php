<?php 

namespace Cache\Laravel;

use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\ConnectorInterface;

class CacheConnector extends Connector implements ConnectorInterface
{

	/**
	 * Establish a database connection.
	 *
	 * @param  array  $options
	 * @return PDO
	 */
	public function connect(array $config)
	{
		$options = $this->getOptions($config);

        $dsn = array_get($config, 'dsn');

		return $this->createConnection($dsn, $config, $options);
	}

}