<?php

class ClimaService
{
    public static function obterDadosMetereologicos($latitude, $longitude)
    {
        /************* Datas *************/
        $agora = new DateTime();

        $ontem = (clone $agora)
            ->modify('-1 day')
            ->format('Y-m-d');

        /************* PREVISÃO - DIA ATUAL *************/
        $urlPrevisao = "https://api.open-meteo.com/v1/forecast?" .
            http_build_query([
                'latitude' => $latitude,
                'longitude' => $longitude,
                'daily' => 'precipitation_sum',
                'forecast_days' => 1,
                'timezone' => 'auto'
            ]);

        $prev = self::executarCurl($urlPrevisao);

        /************* HISTÓRICO - DIA ANTERIOR *************/
        $urlHistorico = "https://archive-api.open-meteo.com/v1/archive?" .
            http_build_query([
                'latitude' => $latitude,
                'longitude' => $longitude,
                'start_date' => $ontem,
                'end_date' => $ontem,
                'daily' => 'precipitation_sum',
                'timezone' => 'auto'
            ]);

        $hist = self::executarCurl($urlHistorico);

        return [
            'chuva_hoje' =>
                $prev['daily']['precipitation_sum'][0] ?? 0,

            'chuva_ontem' =>
                $hist['daily']['precipitation_sum'][0] ?? 0
        ];
    }

    /************* CONSULTA API *************/
    private static function executarCurl($url)
    {
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        return json_decode($response, true);
    }
}