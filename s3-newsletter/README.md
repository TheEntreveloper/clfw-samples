## CodeLib Sample 3: Plugin for Newsletter Subscription

### Description

This sample demonstrates how we can use the Plugin mechanism provided by the Codelib framework, to easily 
add Newsletter subscription to our App.
The above functionality requires the App to be able to _send emails_, _access a database_.
SMTP details and the email library to use, are specified in the configuration. MySql connection details as well.

The details of the email service and the active repository available, are injected into the plugin by the framework.

#### Newsletter Plugin

You will find this plugin in the App's plugin folder. See in index.php how this plugin is wired to respond to requests 
related to "newsletter". Check the Newsletter subscription form, in the About page for one of such requests.

Go through the plugin code and try to make sense of how it works. Look how we just a few short functions we handle the 
functionality required by this sample: 
- Receive a form with a Newsletter subscription request (contains an email address).
- Save the email address to the db, with a pending status.
- Prepare and send an email to the user to confirm the email address.
- If the user presses on the link included in the message, then check it is the correct email address, and it has not 
been confirmed yet, then change the status as confirmed and let the user know.
- The plugin via the framework provides a way to internationalize the App. See the _T() function wrapping messages for 
the user, and take a look at the resources/language/ folder.

More details will be available when the readme receives another update.

### Running this Sample

- First, install the dependencies (framework) by going to the console, at the root of
  this sample, and running **composer install**.
- Create a blank MySql database in your development environment, and execute the SQL script provided inside the 
resources/db folder of the App, in order to create the one table required by this sample.
- Enter your database connection details in config/configData.php
- Specify your SMTP details so that emails can be sent.
- Access this sample **index.php** file via your webserver
- If all goes well, you will see a simple web page displaying content about this sample.
- Try the search form, compare the results with the ones in the previous form and compare the implementations.
- Read the comments in index.php for additional details.


