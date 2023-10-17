## CodeLib Sample 2: Working with Plugins

### Description

This sample demonstrates how we can use the Plugin mechanism provided by the Codelib framework, to easily 
add functionality to our App, instead of having "spaghetti code" inside very long PHP pages, with a lot of logic and html 
mixed with each other.

#### Creating a Plugin

Plugins, by convention are located in the **plugin** folder of your App, although it is possible to configure the App to
use a different folder, like **controller** or **service**, or other, if so you prefer. You can change that by using the
EXTENSIONS_FOLDER configuration entry. For instance,

`$clconfig->addAppConfig(EXTENSIONS_FOLDER, 'controller');` // would change the plugin folder to _controller_

In this sample, you will find one Plugin called _SearchPlugin_, located in the _plugin_ folder of the App.
If you inspect this file, you will notice that:

- the Plugin declares a class with the same name as its file name.
- the Plugin extends the `CLBasePlugin` class, which provides other useful functionality to Plugins.
- instead, a Plugin can implement the **\cl\contract\CLPlugin** if it does not need any of the functionality provided 
by the base class.
- the Plugin receives a **CLServiceRequest** object which includes the request, session and other objects that the 
Plugin might need.
- the Plugin also receives a **CLResponse** object, which it will use to add the result of its own processing. Any Plugin 
method called by the framework to handle a request must return a `CLResponse` object. See the SearchPlugin as an example.

Other important information about Plugins, which you will see in other samples, includes the next few lines:
- plugins **should not echo or print** any information directly to the browser, pages and look and feels do that.
  Plugins, however, can direct their output to specific controls or specific fields within a page, and can indicate what
  page should render the response.
- plugins can receive other dependencies via **dependency injection**, using a mechanism provided by CL.
- plugins can receive **repositories** as dependencies, and in that way, communicate with data stores.

####  Wiring a Plugin into your App

Once a Plugin is created, in order to use it, it must be added to the App instance, via the addPlugin method of the App:

`$app->addPlugin('search', 'SearchPlugin');`

The above code tells Code-lib or CL, to add the SearchPlugin, and to use it to handle a _search_ request.
The key (1st parameter) passed to addPlugin determines what requests it handles. This key can be a string or an array 
of strings.
Each of those strings can be a simple string such as search, or a more coplex string such as user*:
`$app->addPlugin(['user*'], 'MyUserHandlingPlugin');`

The above would allow that plugin to handle requests such as user/login, user/register, etc.

By convention, when CL receives a request it calls the `run` method of a matching plugin, unless you set the pluginMethod 
parameter of `addPlugin`. 
If the plugin extends `CLBasePlugin` then it gets additional handling functionality: if the request key is something like  
_user/login_, ie, with a forward slash separating 2 words, it looks for a method named as the word after the slash 
(in this example _login_) and calls it.
If it cannot find any, then it looks for a method named as the whole key (like in 'search' above), and if it finds it, 
it calls it. If it cannot find that either it returns an error back to the framework. 

#### Variables always available to a Plugin

As mentioned above, a CL plugin always receives a **CLServiceRequest** object which includes the request, session and 
other objects that the plugin might need. That object can be accessed within the plugin as `$this->clServiceRequest`, and 
through its different methods the plugin can get hold of data it needs to function. Here are a few examples:

// get the session and then access a variable within the session

`$session = $this->clServiceRequest->getCLSession();
$username = $session->get('username');`

// do something only if the request was submitted via post

`if ($this->clServiceRequest->getCLRequest()->isPost()) {}`

// access the request (get or post), check if an email field is present, and if not send the response back with feedback:

`$clrequest = $this->clServiceRequest->getCLRequest()->getRequest();
if (!(isset($clrequest['email']))) {
  $this->pluginResponse->setVar('feedback', 'Email address is missing');
  return $this->pluginResponse;
}`

### Running this Sample

- First, install the dependencies (framework) by going to the console, at the root of
  this sample, and running **composer install**.
- Access this sample **index.php** file via your webserver
- If all goes well, you will see a simple web page displaying content about this sample.
- Try the search form, compare the results with the ones in the previous form and compare the implementations.
- Read the comments in index.php for additional details.


