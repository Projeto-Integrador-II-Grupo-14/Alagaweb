<?php

class GeoReferenciamentoService
{
    /************* Obter LAT e LONG *************/
    public static function obterCoordenadas($endereco)
    {
        $url = "https://nominatim.openstreetmap.org/search?" . http_build_query([
            'q' => $endereco,
            'format' => 'jsonv2',
            'limit' => 1
        ]);

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'MeuSistema/1.0',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }

        $dados = json_decode($response, true);

        if (empty($dados)) {
            return null;
        }

        return [
            'latitude' => $dados[0]['lat'],
            'longitude' => $dados[0]['lon']
        ];
    }
}