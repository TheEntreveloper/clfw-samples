<?php
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

$settings = [
CSRFSTATUS => false,
RENDER_ALL => false,
// below, acceptable values for 'phase' are CLREQUEST, CLRESPONSE and BOTH (no quotes around any of them)
HTML_FILTER => ['phase' => CLREQUEST, FILTER_SPECIAL_CHARS => true, FILTER_REMOVE_TAGS => true]
];
$repositories = [
'mysql' => ['server' => 'localhost', 'user' => 'root', 'password' => 'ciler', 'dbname' => 'clsample'] // 'class' => 'cl\store\mysql\CLMySqlRepository'
];
