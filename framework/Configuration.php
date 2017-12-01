<?php 
namespace OC\BlogPost\Framework;

class Configuration 
{
	private static $parameters;

	public static function get($name) 
	{
		if (isset(SELF::getParameters()[$name])) {
			return SELF::$parameters[$name];
		}
	   	return NULL;
	}

	private static function getParameters() 
	{ 
		if (SELF::$parameters == NULL) {
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
			SELF::$parameters = parse_ini_file($filePath);
		}
		return SELF::$parameters;
	}
}