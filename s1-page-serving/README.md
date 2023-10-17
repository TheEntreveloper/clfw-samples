## CodeLib Sample 1: Static Website

### Description

This sample demonstrates showcases how we can quickly create a simple website which only contains static pages
and simple logic.

#### Configuration and Entry point

Take a look at the source code of index.php in this sample. This is the entry point to 
this App.
It is self-explanatory, with the help of the comments included there.
Notice a few things we will do for any regular Codelib App:

- We wire or plug into the Codelib framework (by including the clwiring.php code snippet)
- We Start using the framework via use statements into Codelib namespaces and classes
- We put together a configuration for our app (in the included _config/config.php_)
- We create an instance of a Codelib web app, and add features to it (plugins, pages, etc)

#### Installing Codelib and other dependencies

In this sample we use Composer, and all the dependencies are specified inside our _composer.json_ file.
To install the App simply run composer install from your shell or console. All the dependencies, including Codelib, 
will be installed in the vendor subfolder of the App.
Because Codelib gets installed within the vendor folder, we refer to it in the following line, in clwiring.php:
*define('CL_DIR', BASE_DIR . '/vendor/codelibfw/codelib-fw/src' . DIRECTORY_SEPARATOR);*

#### Creating an App without Composer

Composer is easy to use and useful, but if you prefer not to use it, you can still create a Codelib App.
Simply download Codelib to a suitable folder, and define the CL_DIR constant to point to the src folder of your 
Codelib installation.
Use . DIRECTORY_SEPARATOR as above to make sure it contains a trailing slash.
In the above way, _you can use a single Codelib installation to wire up several Apps_.

#### Defining Pages for your App

A page is defined using the `addPage` method of the $app variable (a method defined in CLHtmlApp). See index.php.
As a minimum, you must pass 2 parameters to addPage: a key to identify and refer to that page, which is the 1st 
parameter and must be a string (or an array of strings if you want to declare several keys for the same page), and an 
array of relative paths to actual pages linked to that key.
_Whenever that key is selected during a request, all the pages linked to the key will be loaded and sent to the browser, 
as part of the response, in the same order in which they were declared_.
The above allows composition of the html screen of a response by combining several html files.

_Pages can have a first layer of security added already at declaration time_ by setting the protection parameter of 
addPage. See the entry for 'mypage' in index.php of the sample.

Out of many pages you might have, _you can set one page as the default page_ by setting the isdefault parameter of `addPage` 
to true.

#### Request handling in Codelib Apps

At the heart of request handling in a Codelib App is a special parameter (referred to in Codelib as the flow key or 
request key).
By default, the name of this parameter is clkey, and it must be passed as part of any get, post or other request. For 
instance, see in parts/header.php how the top menu links for _About_ and _Contact_ are created:
<a class="nav-link active" aria-current="page" href="?clkey=about">About</a> and <a class="nav-link" href="?clkey=contact">Contact</a>
The search form, which is submitted by post, also contains a hidden field for clkey:
<input type="hidden" name="clkey" value="search">

_You can change the default value of the request key_ (clkey) using the `setClKey`() method of the configuration.
See the comment in config/config.php in this sample.

### Running this Sample

- First, install the dependencies (framework) by going to the console, at the root of
  this sample, and running **composer install**.
- Access this sample **index.php** file via your webserver
- If all goes well, you will see a simple web page displaying content about this sample.
- Try navigating using the top menu and the search form.
- Read the comments in index.php for additional details.


