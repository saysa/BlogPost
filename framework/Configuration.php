<?php 
namespace OC\BlogPost\Framework;

class Configuration 
{
	private static $_parameters;

	public static function get($name) 
	{
		if (isset(SELF::getParameters()[$name])) {
			return SELF::$_parameters[$name];
		}
	   	return NULL;
	}

	private static function getParameters() 
	{ 
		if (SELF::$_parameters == NULL) {
			switch (ENVIRONMENT) {
				case 'development':
					$filePath = "Config/dev.ini";
					break;				

				case 'production':
					$filePath = "Config/prod.ini";
					break;
				
			}
			if ( ! file_exists($filePath)) {
			    throw new \Exception("Aucun fichier de configuration trouvé");
			}
			SELF::$_parameters = parse_ini_file($filePath);
		}
		return SELF::$_parameters;
	}
}