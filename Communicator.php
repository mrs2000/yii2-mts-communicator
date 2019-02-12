<?php

namespace mrssoft\mts;

use SoapClient;
use SoapFault;
use yii\base\Component;

/**
 * Extension for sending SMS through MTS Communicator M2M API
 */
class Communicator extends Component
{
    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $wsdlUrl = 'http://www.mcommunicator.ru/m2m/m2m_api.asmx?WSDL';

    /**
     * @var string
     */
    public $naming;

    /**
     * @var SoapClient
     */
    private $client;

    public function init()
    {
        parent::init();

        $this->client = new SoapClient($this->wsdlUrl, ['soap_version' => SOAP_1_2]);
    }

    /**
     * The SendMessage function allows you to send a message to a subscriber connected to the service.
     * @param string $message
     * @param string $phone
     * @param null|string $naming
     * @return \mrssoft\mts\MtsResponse
     */
    public function sendMessage(string $message, string $phone, ?string $naming = null): MtsResponse
    {
        $params['message'] = $message;
        $params['msid'] = $this->preparePhone($phone);
        if ($naming = $this->prepareNaming($naming)) {
            $params['naming'] = $naming;
        }

        return $this->request('SendMessage', $params);
    }

    /**
     * The SendMessages function allows you to send the same messages to several subscribers connected to the service.
     * @param string $message
     * @param array $phones
     * @param null|string $naming
     * @return \mrssoft\mts\MtsResponse
     */
    public function sendMessages(string $message, array $phones, ?string $naming = null): MtsResponse
    {
        $params['message'] = $message;
        $params['MSIDs'] = array_map([$this, 'preparePhone'], $phones);
        if ($naming = $this->prepareNaming($naming)) {
            $params['naming'] = $naming;
        }

        return $this->request('SendMessages', $params);
    }

    private function prepareNaming(?string $naming = null): ?string
    {
        return $naming ?? $this->naming;
    }

    private function preparePhone(string $phone): string
    {
        if (mb_strlen($phone) === 10) {
            return '7' . $phone;
        }
        if (mb_strpos($phone, '8') === 0) {
            return '7' . mb_substr($phone, 1);
        }
        return $phone;
    }

    private function request(string $function, array $params): MtsResponse
    {
        $params['login'] = $this->login;
        $params['password'] = md5($this->password);

        $response = new MtsResponse();

        try {
            $this->client->{$function}($params);
        } catch (SoapFault $e) {
            $response->error = $e->getMessage();
        }

        return $response;
    }
}