To get started

Download Zinc from github:

	git clone git://github.com/rgigger/zinc.git

Set up the command line tool, zn.

	cd ~/bin
	ln -s /path/to/zinc/bin/zn zn

Create a new application.

	zn create app APP_NAME

Create the instance of the application. The instance has it's own configuration, and it's own area for storing data. It
should never be stored under the root web directory.

	zn create instance hello /path/to/the/application/hello

Create the public directory for the application. It is the interface with the web server and must be stored under the 
root web directory.

	zn create pub hello /path/to/the/isntance/hello

Go in your browser to the the URL corresponding to the pubic directory you just created. The page should look something
like this:

![Screenshot of working app](http://rgigger.github.com/firstscreen.png)

Continue on to [the wiki][1] for more information.

[1]: https://github.com/rgigger/zinc/wiki