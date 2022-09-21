<?php
/**
 * HelloPlugin.php
 */

namespace app\plugin\helloplugin;
/**
 * Copyright Codelib Framework (https://codelibfw.com)
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

use cl\contract\CLInjectable;
use cl\contract\CLLogger;
use cl\contract\CLResponse;
use cl\contract\CLServiceRequest;
use cl\core\CLDependency;
use cl\core\CLFlag;

/**
 * Class HelloPlugin
 * @package app\plugin\helloplugin
 */
class HelloPlugin implements \cl\contract\CLPlugin, CLInjectable
{
    private $logger;
    private $clServiceRequest;
    private $pluginResponse;
    private $dependency;

    public function __construct(CLServiceRequest $clServiceRequest, CLResponse $pluginResponse)
    {
        $this->clServiceRequest = $clServiceRequest;
        $this->pluginResponse = $pluginResponse;
    }

    public function run(): CLResponse
    {
        // we can log with this global function
        _log('executing HelloPlugin');
        // or we can log using the logger class injected to our Plugin
        $this->logger->info('always before rendering the output');
        // notice how here we use the injected dependency to produce the output (sayHello)
        $this->pluginResponse->addVars(['_phead.value' => 'HelloPlugin Sets the Page Title',
            '_body.value' => 'HelloPlugin gets output from injected dependency:'.$this->dependency->sayHello()]);
        return $this->pluginResponse;
    }

    public function setPluginDependency($dependency) {
        $this->dependency = $dependency;
    }

    public function setLogger(CLLogger $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @return array required dependencies
     * each entry provides information about a dependency, in the form: CLDependency::new('key'), where key is the key
     * assigned to that dependency. A key is assigned to a dependency, either by Code-lib Fw (CL), or, if not a dependency
     * pre-configured by CL, by a Plugin in your App the first time it is needed.
     * When a dependency is configured for the first time by your App, it must tell the framework where to find it, and
     * how you want it instantiated. Use additional parameters of CLDependency::new to achieve that.
     * For instance, the $classname parameter allows you to specify the full class name (namespace and class name) of
     * your dependency. $exClass allows CL to reinforce what parent class your $classname must extend or implement.
     * Use $params if you need to pass any parameters to the dependency, and $instType to indicate whether this dependency
     * can be shared or not, by using values CLFlag::SHARED or CLFlag::NOT_SHARED.
     * is an array as well, which specifies the dependency key, optional class, optional params, and optional instantiation
     * type. Ex.:
     * return [CLDependency::new('cache', null, null, null, CLFlag::SHARED)],  // <-- requires a cache instance. CL knows about
     * this key, so no class is required
     * return [CLDependency::new('mysmartclass', '\app\core\Smartest.php', null, null, CLFlag::NOT_SHARED)]; // <-- requires this
     * App class, Smartest, which CL might not know about, so we tell it where to find it.
     * If CL finds the required dependency, it will inject it in your Plugin, using a setter method based on the dependency key.
     * So, in the example above, it would call: setCache(cacheInstance); and setMysmartclass(smartInstance);
     * as it would expect those setter methods to be available in your Plugin
     */
    public function dependsOn(): array
    {
        return [new CLDependency('pluginDependency','\app\plugin\helloplugin\PluginDependency',null,null,CLFlag::SHARED)];
    }
}
