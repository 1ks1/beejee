<?PHP

spl_autoload_register(function($className) {
	$ds = DIRECTORY_SEPARATOR;
	$dirs = [
		ROOT . $ds . 'controllers' . $ds,
		ROOT . $ds . 'classes' . $ds,
		ROOT . $ds . 'views' . $ds,
		ROOT . $ds . 'models' . $ds
	];
	foreach ($dirs as $dir) {
		if (file_exists($dir . $className . '.php')) {
			require_once($dir . $className . '.php');
		}
	}
	
});