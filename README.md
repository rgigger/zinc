To get started

Download Zinc from github:

	git clone git://github.com/rgigger/zinc.git

Set up the command line tool, zn.

	cd ~/bin
	ln -s /path/to/zinc/bin/zn zn

Create a new application.

	zn create app APP_NAME

Create the instance of the application. The instance has it's own configuraion and is the
interface with the web server. It goes in the public_html or Sites directory.

	zn create instance hello /path/to/the/application/hello
	
Go to the the URL cooresponding to the instance in a browser. The page should look something like this:

![Screenshot of working app](http://rgigger.github.com/firstscreen.png)