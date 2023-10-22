<?php

/**
 * index.php
 */

namespace app;

/**
 * Copyright Codelib Framework (https://codelibfw.com)
 * Sample Application
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// Wire in Codelib framework
include_once 'clwiring.php';
// Start using the framework
use cl\web\CLDeployment;
use cl\web\CLHtmlApp;
// Now we work on building our App
// We create a configuration for our app
include_once 'config/config.php';

// now we put together our app
$app = new CLHtmlApp();
// we can add plugins, pages, configurations, etc to handle specific functionality
$app
    // In this sample we keep the same search functionality we implemented in Sample 2 (S2).
    ->addPlugin(['search*'], 'SearchPlugin')
    // We wire our User Plugin
    ->addPlugin(['user/*'], 'UserPlugin')
    // let's create a few pages (frontend) for our use cases: about, contact, search, error page, notfound page, etc
    // The framework finds pages by convention: it looks for them within the lookandfeel/html/ folder of the app.
    // Pages can be added directly to this folder, or they can be in subfolders of this folder.
    // So, below, 'parts/header' exists as parts/header.php (you can include or omit the extension) and will be
    // used as the main or heading of that page, whereas 'about' will be used as the content of the page, and 'parts/footer',
    // as the footer of the page. This means we can associate one page key, with one or with several actual pages.
    // We can also associate several key with the same set of actual pages, if we wish.
    // So, for the 1st page below, 'about' is the key, and it is associated with 'parts/header', 'pages/about', and
    // 'parts/footer'. Then (optionally) we can also define variables for that page. In this case we only define the
    // 'title' variable, which the actual page will use.
    // Notice that we have several pages. If the user goes to the root domain, which content we choose to display?
    // The answer is: the 'about' page in this case because the true value for its 'isdefault' parameter, sets it as
    // the default page. You can change that to make any other page the default page.
    ->addPage(['about'], ['parts/header', 'pages/about', 'parts/footer'], array(
        'title' => 'About page for Codelib sample S3'), 'none', true)
    ->addPage(['contact'], ['parts/header', 'pages/contactpage', 'parts/footer'], array(
        'title' => 'Contacting me'
    ), 'none')
    ->addPage(['register', 'user/register'], ['parts/header', 'pages/register', 'parts/footer'], array(
        'title' => 'Registration page for Codelib Sample S4'))
    ->addPage(['login', 'user/login'], ['parts/header', 'pages/login', 'parts/footer'], array(
        'title' => 'Login page for Codelib Sample S4'))
    // Page for user dashboard. Notice how page variables can have static values or values we do not know at this time,
    // such as username which takes its value once the user login, from the session key: username (as in $_SESSION['username']).
    // Notice also that access to this page has 'LoggedIn' protection
    ->addPage(['userdash'], ['pages/userdashboard', 'parts/footer'], array(
        'title' => 'User Dashboard for Codelib Sample S4', 'pagename' => 'Product Name', 'username' => 'session.username'), LOGGED_IN)
    // Notice how the admin page has ADMIN protection. So, after login as a regular user, you can go to your dashboard: clkey=userdash,
    // but try going to the admin dashboard: clkey=admdash and you should get an error: 'Access to page denied. No privileges'.
    // Now, if you remove the protection or make it just 'LoggedIn' as in previous page, then you should have access to the admin page.
    // So, a simple parameter in your page declaration will already limit access to a page to a specific role or roles
    // (you can also specify protection as 3+, to indicate that any role with access level 3 or higher can access your page).
    ->addPage(['admdash'], ['pages/admdashboard', 'parts/footer'], array(
        'title' => 'Admin Dashboard for Codelib Sample S4', 'pagename' => 'Product Name', 'username' => 'session.username'), ADMIN)
    ->addPage(['search'], ['parts/header', 'pages/searchpage', 'parts/footer'], array(
        'title' => 'Search Results'
    ), 'none')
    ->addPage(['feedback'], ['parts/header', 'pages/feedbackpage', 'parts/footer'], array(
        'title' => 'Codelib PHP Framework - Sample 3'
    ), 'none')
    // the framework provides pre-defined keys for the error page and the not found page, as well as a default
    // implementation of such pages. In this case, we overwrite the default implementations with our own error and
    // notfound pages.
    // Notice how we actually use the same physical page for both: pages/feedbackpage but with different key and
    // different values for certain variables.
    ->addPage([ERRORPAGE], ['parts/header', 'pages/feedbackpage', 'parts/footer'], array(
        'title' => 'Error condition', 'feedbackcolor' => 'red', 'feedbacktitle' => 'Error Page'), 'none')
    ->addPage([NOTFOUNDPAGE], ['parts/header', 'pages/feedbackpage', 'parts/footer'], array(
        'title' => 'Request Not found', 'feedbackcolor' => 'blue', 'feedbacktitle' => 'Not Found',
        'feedback' => 'What you are looking for is missing in action.'), 'none')
    // finally, we add one deployment and set it as active (we can add many different deployments for dev, prod, etc)
    ->setDeployment(new CLDeployment($env, $clconfig), true)
    // and we run our app.
    ->run();
