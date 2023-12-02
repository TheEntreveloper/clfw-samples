<?php

namespace app\plugin;

use cl\core\CLFlag;
use GuzzleHttp\Exception\RequestException;

class OpenAIPlugin extends \cl\plugin\CLAIPlugin
{
    protected function gpt()
    {
        $clrequest = $this->clServiceRequest->getCLRequest()->getRequest();
        if (!(isset($clrequest['apientry'])) || !in_array($clrequest['apientry'], ['genimage', 'completion'])) {
            return $this->prepareResponse(_T('Unfortunately a required field is missing'), CLFlag::FAILURE, null, $clrequest);
        }
        $apientry = $clrequest['apientry'];
        return $this->$apientry($clrequest);
    }

    private function completion($clrequest) {
        if (!isset($clrequest['sysrole']) && !isset($clrequest['userrole'])) {
            return $this->prepareResponse(_T('Unfortunately a required field is missing'), CLFlag::FAILURE, null, $clrequest);
        }
        $msgs = [];
        if (isset($clrequest['sysrole'])) {
            $msgs[] = [
                "role" => "system",
                "content" => $clrequest['sysrole']
            ];
        }
        if (isset($clrequest['userrole'])) {
            $msgs[] = [
                "role" => "user",
                "content" => $clrequest['userrole']
            ];
        }
        $request['data'] = [
        "model" => $clrequest['model'] ?? "gpt-3.5-turbo",
        "messages" => $msgs
        ];
        $request['uri'] = 'chat/completions';
        $this->sendAiApiRequest($request);
        $aiResponse = $this->pluginResponse->getVar('aiResponse');
        $payload = $aiResponse->getPayload();
        $jsondata = json_decode($payload[0], true);
        $gptResponse = [];
        foreach ($jsondata['choices'] as $choice) {
            $gptResponse[] = $choice['message']; // message['role'=>'assistant','content'=>'whatever...'];
        }
        $this->pluginResponse->setVar('apiquery', 'completion');
        $this->pluginResponse->setVar('gptoutput', $gptResponse);
        $this->pluginResponse->setVar('usedtokens', $jsondata['usage']['total_tokens']);
        return $this->pluginResponse;
    }

    private function genimage($clrequest) {
        if (!isset($clrequest['sysrole']) || mb_strlen($clrequest['sysrole']) === 0) {
            return $this->prepareResponse(_T('Unfortunately a required field is missing'), CLFlag::FAILURE, null, $clrequest);
        }
        $request['data'] = [
            "model" => $clrequest['model'] ?? "dall-e-3",
            "prompt" => $clrequest['sysrole'],
            "n" => 1,
            "size" => "1024x1024"
        ];
        $request['uri'] = 'images/generations';
        try {
            $this->sendAiApiRequest($request);
            $aiResponse = $this->pluginResponse->getVar('aiResponse');
            if ($aiResponse->getVar('status') === '501') {
                return $this->prepareResponse(_T('Server did not respond'), CLFlag::FAILURE, null, $clrequest);
            }
            $payload = $aiResponse->getPayload();
            $jsondata = json_decode($payload[0], true);
            $gptResponse = [];
            foreach ($jsondata['data'] as $img) {
                $gptResponse[] = $img['url']; // message['role'=>'assistant','content'=>'whatever...'];
            }
            $this->pluginResponse->setVar('apiquery', 'genimage');
            $this->pluginResponse->setVar('gptoutput', $gptResponse);
            $this->pluginResponse->setVar('usedtokens', $jsondata['usage']['total_tokens']);
        }catch(RequestException $e) {
            $this->pluginResponse->setVar('apiquery', 'genimage');
            $this->pluginResponse->setVar('feedback', 'The API responded with an error: '.$e->getMessage());
        }
        return $this->pluginResponse;
    }
}
