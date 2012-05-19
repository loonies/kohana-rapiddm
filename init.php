<?php defined('SYSPATH') or die('No direct script access.');

require Kohana::find_file('vendor', 'rapiddm/lib/Rdb');

Rdb::initAutoload();

spl_autoload_register(array('RapidDM', 'auto_load'));
