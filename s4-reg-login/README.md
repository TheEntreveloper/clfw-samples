## CodeLib Sample 4: Plugin for User Registration and Login

### Description

This sample demonstrates how easy it is to leverage the Codelib framework, in order to add User registration, login and 
User Dashboard to our App.
As with the S3 sample, the above functionality requires the App to be able to _access a database_.
You must enter your MySql connection details in the config/configData.php file.

The active MySql repository will be injected into the plugin by the framework, so there is no need for Plugin logic to 
also look for a MySql class and include or require it.

#### User Plugin

You will find this plugin in the App's plugin folder. See in index.php how this plugin is wired to respond to requests 
related to "user". Submitting the registration and login forms will trigger code execution in this plugin.

Go through the plugin code and try to make sense of how it works. It is short and simple, and yet, with the help of the 
framework, it handles user registration and login for a Codelib App like this one.  

More details with another update. Please follow the comments and code inside UserPlugin and index.php to make sense of the code.
Take a look at the relevant pages too, such as register.php, login.php and userdashboard.php.

### Running this Sample

- First, install the dependencies (framework) by going to the console, at the root of
  this sample, and running **composer install**.
- Create a blank MySql database in your development environment (or use the db from the previous sample), and using a tool 
such as PhpMyAdmin or any MySql client, execute the SQL script provided inside the resources/db folder of the App, in 
order to create the one table required by this sample.
- Enter your database connection details in config/configData.php
- Access this sample **index.php** file via your webserver
- If all goes well, you will see a simple web page displaying content about this sample.
- Using the menu, go to the registration form, and try to register. Then once registered, try login in.
- Read the comments in index.php, config.php and UserPlugin for additional details.


