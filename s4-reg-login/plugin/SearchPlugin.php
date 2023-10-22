<?php
/**
 * SearchPlugin.php
 */

namespace app\plugin;
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


use app\util\traits\ActiveRepoIoCHelper;
use app\util\traits\ApiHelper;
use cl\contract\CLInjectable;
use cl\contract\CLLogger;
use cl\contract\CLResponse;
use cl\contract\CLServiceRequest;
use cl\core\CLDependency;
use cl\core\CLFlag;
use cl\plugin\CLBaseResponse;
use cl\plugin\CLUserPlugin;
use DateTime;
use OpenAPI\Client\ApiException;
use OpenAPI\Client\co\nexterday\learn\api\model\Choice;
use OpenAPI\Client\co\nexterday\learn\api\model\CourseLesson;
use OpenAPI\Client\co\nexterday\learn\api\model\User;
use app\util\CourseUtil;

/**
 * Class SearchPlugin
 * @package app\plugin
 */
class SearchPlugin extends \cl\plugin\CLBasePlugin
{
    protected function search() {
        if (!$this->clServiceRequest->getCLRequest()->isPost()) {
            return $this->pluginResponse;
        }
        $query = $this->clServiceRequest->getCLRequest()->post('keywords') ?? null;
        if (isset($query)) {
            $results = $this->doSearch($query);
            $this->pluginResponse->setVar('results', $results);
        }
        return $this->pluginResponse;
    }

    protected function test() {
        _log('test ran');
        return $this->pluginResponse;
    }

    private function getFragment($content, $keyword) {
        return '... '.str_replace($keyword, "<b>$keyword</b>", strip_tags($content));
    }

    private function doSearch($query) {
        //
        $query = mb_strtolower($query);
        $query = str_replace(',',' ',$query);
        $keywords = explode(' ', $query);
        // path to our pages
        $path = BASE_DIR . '/lookandfeel/html/pages/';
        // list of pages we will search
        $pages = ['about.php', 'contactpage.php'];
        $results = [];$distribution = [];
        foreach($pages as $page) {
            $content = file_get_contents($path.$page);
            foreach($keywords as $keyword) {
                $distribution[$page][$keyword] = substr_count($content, $keyword);
                if ($distribution[$page][$keyword] > 0) {
                    $results[] = ['page' => $page, 'fragment' => $this->getFragment($content, $keyword)];
                }
            }
        }
        return count($results) > 0 ? $results : [['page'=>'','fragment'=>'Nothing found']];
    }
}
