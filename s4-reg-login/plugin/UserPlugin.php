<?php

namespace app\plugin;
use cl\core\CLFlag;
use cl\plugin\CLUserPlugin;
use cl\store\CLBaseEntity;

!defined('CL_DIR') ? die(':-)') : '';

/**
 * class UserPlugin
 * it extends a framework class: CLUserPlugin which will handle the registration and login for us (adding user to our
 * db, etc)
 * This class leverages that functionality and then adds whatever other logic our App requires when an user registers
 * or login.
 */
class UserPlugin  extends CLUserPlugin {

    /**
     * Called when a Login form is submitted
     * @return \cl\contract\CLResponse|\cl\plugin\CLBaseResponse|null
     */
    protected function login() {
        // we call parent to handle login and just get back the response (result of the login attempt)
        $this->pluginResponse = parent::login();
        if ($this->pluginResponse->getVar('status') === CLFlag::SUCCESS) {
            // if success, let's show the user dashboard
            if ($this->pluginResponse->getVar('user')['role'] === self::ADMIN) {
                // load the admin dashboard
                $this->pluginResponse->setVar('page', 'admdash');
            } else {
                // load the user dashboard
                $this->pluginResponse->setVar('page', 'userdash');
            }
            $session = $this->clServiceRequest->getCLSession();
            // let's add the role to the session so later we can check for it
            $session->put(CLFlag::ROLE_ID, $this->pluginResponse->getVar('user')['role']);
            $this->pluginResponse->setVar('loggedIn', true);
        } else {
            // otherwise, let's go back to the login page
            $this->pluginResponse->setVar('page', 'login');
            // with an error message for the user
            $this->pluginResponse->setVar('feedback', _T('Login details were not found'));
        }
        return $this->pluginResponse;
    }

    /**
     * Called when a registration form is submitted
     * @return \cl\contract\CLResponse|\cl\plugin\CLBaseResponse|null
     */
    protected function register() {
        // Let's get hold of the request
        $clrequest = $this->clServiceRequest->getCLRequest()->getRequest();
        // we do a minimal validation for this sample
        if (!(isset($clrequest['username']) && isset($clrequest['password']) && isset($clrequest['email']))) {
            // this function provides another way of preparing a response.
            return $this->prepareResponse(_T('Unfortunately required fields are missing'), CLFlag::FAILURE,null, $this->clServiceRequest->getCLRequest()->getRequest());
        }
        // we ask Codelib to handle the registration for us
        $this->pluginResponse = parent::register();
        if ($this->pluginResponse->getVar('status') === CLFlag::SUCCESS) {
            // if success, go to the login page and let the user know that all went well
            $this->pluginResponse->setVar('feedback', _T('Success, you can now Login below'));
            $this->pluginResponse->setVar('page', 'login');
        } else {
            $this->pluginResponse->setVar('feedback', _T('Unfortunately registration failed'));
            $this->pluginResponse->setVar('page', 'register');
        }
        return $this->pluginResponse;
    }

    /**
     * Dealing with additional fields (columns in our user table) not catered for by Codelib (cannot cater for all possible
     * requirements)
     * So, we override requestToUserEntity() which is called by the framework registration function before registering the user
     * By default this function returns an Entity with 3 fields: username, password and email.
     * For this example, we have an extra required field: role (see Sql script in resources/db/user.sql) as it is a not null
     * table column.
     * So, we simply intercept that method, still call the parent method to benefit from what it does for us, and then just
     * add our additional field to the created Entity's dataset.
     * @return CLBaseEntity|null the entity with the user details to register
     */
    protected function requestToUserEntity(): ?CLBaseEntity {
        $entity = parent::requestToUserEntity();
        $data = &$entity->getData();
        $data['role'] = USER;
        return $entity;
    }
}
