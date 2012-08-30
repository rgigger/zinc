## Layout of application and instance files

The layout of files in a Zinc application is as follows:

	App.php - this is where you tell the application what libraries and classes to include in your application
	config.yaml - this is where you set default configuration values for all instances of your application
	domains - this is where your you put your classess containing domain logic (models)
	migrations - this is where you store scripts to make changes to persisted data (most likly a relational database)
	public - this is where your store static public assets
	stationary - this directory contiains templates for auto-generated files (migrations, zones, models, etc)
	templates - this is where you store templates for generating content to be sent to the browser (views)
	tmp - this is where the application can create temporary files
	zones - this is where the front controller classes are stored (controllers)

The layout of files in a Zinc instance is as follows:

	config.yaml - this is where instance specific configuration values go
	const.php - contains defines used by zn and Zinc for the instance and application directories
	init.php - including this file will do all the basic setup required to bootstrap an application instance
	