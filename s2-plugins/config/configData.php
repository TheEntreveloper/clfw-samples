<?php
// Example of Config data used by Codelib apps, with details for Prod and Dev
// This file can be different for different developers in a team,
// and can have sensitive information,
// so, it is better to exclude it from source control

// Dev
const dbServer = 'localhost';
const dbUser = 'dbuser';
const dbPass = 'dbpass';
const dbName = 'devdbname';
// Prod
const dbServerProd = 'localhost';
const dbUserProd = 'proddbuser';
const dbPassProd = 'proddbpass';
const dbNameProd = 'proddbname';
// email config
const emailLib = 'phpmailer';
const emailHost = 'mail.mydomain.com';
const emailUser = 'me@mydomain.com';
const emailPass = 'myemailpassw';
const emailPort = 465;
