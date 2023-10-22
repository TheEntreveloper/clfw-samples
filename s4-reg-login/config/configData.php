<?php
// Example of Config data used by Codelib apps, with details for Prod and Dev
// This file can be different for different developers in a team,
// and can have sensitive information,
// so, it is better to exclude it from source control

// Db connection details
const db = ['dev' => ['server' => 'localhost','user' => 'root','pass' => '','dbname' => 'cls4'],
           'prod' => ['server' => 'localhost','user' => 'root','pass' => '','dbname' => 'cls4']];
// we define some user roles
const USER = 1;
const ADMIN = 3;
