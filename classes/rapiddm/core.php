<?php defined('SYSPATH') or die('No direct script access.');
/**
 * RapidDM initialization helper class
 *
 * @package    RapidDM
 * @category   Base
 * @author     Miodrag Tokić
 * @copyright  (c) 2011-2012, Miodrag Tokić
 * @license    MIT
 */
class RapidDM_Core {

	// Current version
	const VERSION = '0.1';

	/**
	 * Loads RapidDM database connections
	 *
	 * @param   array   Groups to initialize
	 * @return  void
	 */
	public static function config(array $groups)
	{
		$config = Kohana::$config->load('database');

		foreach ($groups as $name)
		{
			$conf = array(
				'dbdriver' => $config[$name]['type'],
				'hostname' => $config[$name]['connection']['hostname'],
				'database' => $config[$name]['connection']['database'],
				'username' => $config[$name]['connection']['username'],
				'password' => $config[$name]['connection']['password'],
				'pconnect' => $config[$name]['connection']['persistent'],
				'dbprefix' => $config[$name]['table_prefix'],
				'cache_on' => $config[$name]['caching'],
				'char_set' => $config[$name]['charset'],
			);

			Rdb::setConnectionConfig($name, $conf);
		}
	}

	/**
	 * Auto loader for RapidDM descriptors
	 *
	 * @param   string  Descriptor class name
	 * @return  bool
	 */
	public static function auto_load($class)
	{
		if (strpos($class, 'Descriptor') !== FALSE)
		{
			try
			{
				// This is a descriptor
				$class = str_replace(array('model_', 'Descriptor'), '', $class);

				// Transform the class name into a path
				$file = str_replace('_', '/', strtolower($class));

				if ($path = Kohana::find_file('classes/descriptor', $file))
				{
					// Load the class file
					require $path;

					// Class has been found
					return TRUE;
				}

				// Class is not in the filesystem
				return FALSE;
			}
			catch (Exception $e)
			{
				Kohana_Exception::handler($e);
				die;
			}
		}
	}
}
