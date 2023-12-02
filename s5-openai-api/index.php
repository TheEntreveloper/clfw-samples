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
    // Our OpenAI Plugin.
    ->addPlugin(['ai/*'], 'OpenAIPlugin')
    // Our default page, from which we decide what we want to request from ChatGPT (via the OpenAI API)
    ->addPage(['gpt', 'ai/main'], ['parts/header', 'pages/gptquery', 'parts/footer'], array(
        'title' => 'Let\'s Ask ChatGPT'), 'none', true)
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
