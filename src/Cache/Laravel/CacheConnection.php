<?php 

namespace Cache\Laravel;

use Illuminate\Database\Connection;

class CacheConnection extends Connection {

	/**
	 * Get the default query grammar instance.
	 *
	 * @return Illuminate\Database\Query\Grammars\Grammars\Grammar
	 */
	protected function getDefaultQueryGrammar()
	{
        return $this->withTablePrefix(new CacheQueryGrammar);
	}

	/**
	 * Get the default schema grammar instance.
	 *
	 * @return Illuminate\Database\Schema\Grammars\Grammar
	 */
	protected function getDefaultSchemaGrammar()
	{
        return $this->withTablePrefix(new CacheSchemaGrammar);
	}

	/**
	 * Run a select statement against the database.
	 *
	 * @param  string  $query
	 * @param  array   $bindings
	 * @return array
	 */
	public function select($query, $bindings = array())
	{
		return $this->run($query, $bindings, function($me, $query, $bindings)
		{
			if ($me->pretending()) return array();

			// For select statements, we'll simply execute the query and return an array
			// of the database result set. Each element in the array will be a single
			// row from the database table, and will either be an array or objects.

			// dd($query);

			$statement = $me->getPdo()->prepare($query);

			$statement->execute($me->prepareBindings($bindings));

			return $statement->fetchAll($me->getFetchMode());
		});
	}

	/**
	 * Execute an SQL statement and return the boolean result.
	 *
	 * @param  string  $query
	 * @param  array   $bindings
	 * @return bool
	 */
	public function statement($query, $bindings = array())
	{
		return $this->run($query, $bindings, function($me, $query, $bindings)
		{
			if ($me->pretending()) return true;

			$bindings = $me->prepareBindings($bindings);

			return $me->getPdo()->prepare($query)->execute($bindings);
		});
	}


}