<?php

namespace App\Http\Services\ApiTerminalsWebsocket;

use App\Http\Services\ApiTerminalsWebsocket\BaseClient;



class RecognitionTerminalsClient extends BaseClient
{


    public function sync($data): array
    {

        $response = $this->client->request(
            'POST',
            'recognition/terminals/sync',
            [
                'json' => $data
            ]
        );

        $contents  = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        return $data;
    }





    public function reset($id, $data): array
    {

        $response = $this->client->request(
            'PUT',
            'recognition/terminals/' . $id.'/reset',
            [
                'json' => $data
            ]
        );

        $contents  = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        return $data;
    }


    public function show($id): array
    {

        $response = $this->client->request(
            'GET',
            'recognition/terminals/' . $id
        );

        $contents  = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        return $data;
    }




    public function index(): array
    {

        $response = $this->client->request(
            'GET',
            'recognition/terminals'
        );

        $contents  = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        return $data;
    }


    public function destroy($id): array
    {

        $response = $this->client->request(
            'DELETE',
            'recognition/terminals/' . $id
        );

        $contents  = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        return $data;
    }


    public function status($id, bool $status): array
    {

        $response = $this->client->request(
            'PUT',
            'recognition/terminals/' . $id.'/status',
            [
                'json' => ['status'=> $status]
            ]
        );

        $contents  = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        return $data;
    }

}
