<?php

class Translator
{
    private $key = '0123456789abcdef0123456789abcdef'; // REPLACE THIS WITH YOUR OWN KEY FROM THE AZURE TRANSLATION RESOURCE
    private $token;

    public function translate($string, $to, $from = 'en')
    {
        if (empty($this->token))
        {
            $this->token =  $this->getToken();
        }

        $url = 'http://api.microsofttranslator.com/v2/Http.svc/Translate?appId=&text=' . urlencode($string) . "&from=$from&to=$to";

        $authHeader = "Authorization: Bearer ". $this->token;

        $response = $this->transRequest($url, $authHeader);

        $xml = simplexml_load_string($response);

        if (empty($xml[0]))
        {
            throw new Exception("translate() failed - response from server was [$response]");
        }

        return (string) $xml[0];
    }

    private function getToken()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.cognitive.microsoft.com/sts/v1.0/issueToken');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Ocp-Apim-Subscription-Key: ' . $this->key, 'Content-length: 0']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt( $ch, CURLOPT_VERBOSE, true ); // Uncomment this line to enable some very useful debugging output

        $strResponse = curl_exec($ch);
        $curlErrno = curl_errno($ch);

        if ($curlErrno)
        {
            $curlError = curl_error($ch);
            curl_close($ch);
            throw new Exception($curlError);
        }

        curl_close($ch);

        $objResponse = json_decode($strResponse);

        if ( isset($objResponse->message))
        {
            throw new Exception($objResponse->statusCode . ': ' . $objResponse->message); // FYI - message is HTML formatted
        }

        return $strResponse;
    }

    private function transRequest($url, $authHeader)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [$authHeader, 'Content-Type: text/xml']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $curlResponse = curl_exec($ch);
        $curlErrno = curl_errno($ch);

        if ($curlErrno)
        {
            $curlError = curl_error($ch);
            curl_close($ch);
            throw new Exception($curlError);
        }

        curl_close($ch);

        return $curlResponse;
    }
}