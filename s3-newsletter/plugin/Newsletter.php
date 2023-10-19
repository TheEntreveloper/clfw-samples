<?php

namespace app\plugin;

use cl\contract\CLInjectable;
use cl\contract\CLResponse;
use cl\core\CLDependency;
use cl\core\CLFlag;
use cl\store\CLBaseEntity;
use cl\util\traits\ActiveRepoIoCHelper;

/**
 * Class Newsletter
 * This plugin handles Newsletter subscription for this App
 * @package app\plugin
 */
class Newsletter extends \cl\plugin\CLBasePlugin implements CLInjectable
{
    use ActiveRepoIoCHelper;
    private $emailService;
    private $activeRepo;
    private const ACCEPTED = 4;

    /**
     * executes when an user submits the Newsletter subscription form (in the About us page)
     *
     * @return CLResponse|\cl\plugin\CLBaseResponse|null
     */
    protected function subscribe() {
        $clrequest = $this->clServiceRequest->getCLRequest()->getRequest();
        if (!(isset($clrequest['email']))) {
            return $this->prepareResponse(_T('Unfortunately a required field is missing'), CLFlag::FAILURE,null, $this->clServiceRequest->getCLRequest()->getRequest());
        }

        $entity = new CLBaseEntity('invite');
        $data = array();
        $data['thename'] = 'Website subscriber';
        $data['email'] = $clrequest['email'];
        $data['realm'] = 'Newsletter';
        $data['status'] = 1;
        $data['code'] = sha1($data['email']);
        $entity->setData($data);
        $this->getActiveRepo()->connect();
        if ($this->getActiveRepo()->create($entity)) {
            $domain = $this->getAppConfig("domain", null);
            $supportEmailAddr = $this->getAppConfig("supportemail", null);
            $domain = startsWith($domain, 'http') ? $domain : 'https://'.$domain;
            if (!isset($domain) || !isset($supportEmailAddr)) {
                throw new \Exception(_T("Site not properly configured. Domain and Support Email address not set"));
            }
            $templ = \cl\util\Util::loadFile(BASE_DIR.'/resources/templates/newslemailconfirm.html');
            if ($this->sendEmailInvites($data['email'], $domain, $supportEmailAddr, $templ)) {
                $this->pluginResponse->addVars(['feedbacktitle' => _T('Thank you for subscribing!'), 'feedbackcolor' => 'green']);
                $this->pluginResponse->setVar('feedback', _T('Thank you! We have sent you an email to confirm your email address'));
                $this->pluginResponse->setVar('page', 'feedback');
                return $this->pluginResponse;
            }
        }
        $this->pluginResponse->addVars(['feedbacktitle' => _T('Something is not right'), 'feedbackcolor' => 'red']);
        $this->pluginResponse->setVar(ERRORPAGE, _T('Unfortunately we were unable to subscribe you to our newsletter'));
        // here we tell the framework to use the feedback page (declared in index.php) instead of going back to the About page:
        // A plugin, optionally, can always change the default page for a request.
        $this->pluginResponse->setVar('page', 'feedback');
        return $this->pluginResponse;
    }

    /**
     * executes when the user clicks on the link to confirm the email address.
     * it changes the status of the invitation to 'accepted'.
     * @return CLResponse|null
     */
    protected function confirm() {
        $clrequest = $this->clServiceRequest->getCLRequest()->getRequest();
        if (!isset($clrequest['invid']) || mb_strlen($clrequest['invid']) === 0) {
            $this->pluginResponse->setVar('page', 'feedback');
            $this->pluginResponse->setVar('feedback', _T('Invitation id is missing'));
            return $this->pluginResponse;
        }
        $invite = $this->getActiveRepo()->read('invite', "code = ? and status = ?", array($clrequest['invid'], 2));
        if (count($invite) === 0) {
            _log('Did not find any invitation with code '.$clrequest['invid'], LOGERROR);
            $this->pluginResponse->setVar('page', 'feedback');
            $this->pluginResponse->setVar('feedback', _T('Invitation id provided was not found'));
            return $this->pluginResponse;
        }
        $entity = new CLBaseEntity('invite');
        $entity->setId($invite[0]->getData()['id']);
        $entity->setData(['status' => Newsletter::ACCEPTED]);
        if ($this->getActiveRepo()->update($entity)) {
            $this->pluginResponse->addVars(['feedbacktitle' => _T('Thank you!'), 'feedbackcolor' => 'green']);
            $this->pluginResponse->setVar('feedback', _T('You have subscribed to our Newsletter!'));
            $this->pluginResponse->setVar('page', 'feedback');
        } else {
            $this->pluginResponse->addVars(['feedbacktitle' => _T('Something did not go well'), 'feedbackcolor' => 'red']);
            $this->pluginResponse->setVar('feedback', _T('Confirmation failed, it might be us. Please try again later'));
            $this->pluginResponse->setVar('page', 'feedback');
        }
        return $this->pluginResponse;
    }

    private function sendEmailInvites($email, $site, $supportEmailAddr, $templ) {
        $result = $this->getActiveRepo()->read('invite', "email = ?", array($email));
        if ($result === null || count($result) === 0) {
            return false;
        }
        $invite = $result[0];
        $emailaddr = $invite->getData()['email'];
        $invcode = $invite->getData()['code'];
        $templ = str_replace('{$clkey}', $this->getAppConfig('clkey'), $templ);
        $templ = str_replace('{$domain}', $site, $templ);
        $templ = str_replace('{$invcode}', $invcode, $templ);
        $sentOk = $this->emailService->send(\cl\util\Util::prepareMessage($supportEmailAddr, $emailaddr, _T('Confirm your email address to subscribe to our Newsletter'), $templ));
        if ($sentOk) {
            $entity = new CLBaseEntity('invite');
            $entity->setId($invite->getData()['id']);
            $entity->setData(['status' => 2]);
            $this->getActiveRepo()->update($entity);
            return true;
        }
        return false;
    }

    private function prepareMessage($fromEmail, $usermail, $subject, $message) {
        return ['to' => $usermail, 'from' => $fromEmail, 'subject' => $subject, 'message' => $message];
    }

    /**
     * Setter for the email service
     * @param $emailService
     * @return $this
     */
    public function setEmailService($emailService)
    {
        $this->emailService = $emailService;
        return $this;
    }

    /**
     * Specify what dependencies the Plugin needs (the framework will inject them) using a setter which
     * your plugin must provide for each. See setEmailService() above.
     * There is also a setter for the ActiveRepo (for the MySql repository), but where is it?
     * As you probably guessed if you looked at the code, it is in the trait this plugin uses.
     * @return array
     */
    public function dependsOn(): array
    {
        return [CLDependency::new(EMAIL_SERVICE), CLDependency::new(ACTIVE_REPO)];
    }
}
