<?php

use App\Models\OAuthClient;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

function getRandomId()
{
    return abs(crc32(uniqid()));
}

function bcrypt($str)
{
    return app('hash')->make($str);
}

function uuid()
{
    return Ramsey\Uuid\v4();
}

function getFileSize($bytes, $decimal = 2)
{
    $size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimal}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

function uploadFile($request, $key, $directory)
{
    $destination = base_path('/public' . $directory);

    if (!file_exists($destination)) {
        mkdir($destination, 0777, true);
    }

    $originalName = $request->file($key)->getClientOriginalName();
    $pieces = explode('.', $originalName);
    $size = $request->file($key)->getSize();
    $size = getFileSize($size);
    $mimeType = $request->file($key)->getClientMimeType();
    $extension = end($pieces);

    $file = uuid() . '.' . $extension;

    if ($request->file($key)->move($destination, $file)) {
        return [
            'originalName' => $originalName,
            'name' => $file,
            'size' => $size,
            'type' => $mimeType,
            'path' => $directory . '/' . $file
        ];
    }

    return null;
}

function uploadAttachment($file, $directory)
{
    $destination = base_path('/public' . $directory);

    if (!file_exists($destination)) {
        mkdir($destination, 0777, true);
    }

    $originalName = $file->getClientOriginalName();
    $pieces = explode('.', $originalName);
    $size = $file->getSize();
    $size = getFileSize($size);
    $mimeType = $file->getClientMimeType();
    $extension = end($pieces);

    $filename = uuid() . '.' . $extension;

    if ($file->move($destination, $filename)) {
        return [
            'originalName' => $originalName,
            'name' => $filename,
            'size' => $size,
            'type' => $mimeType,
            'path' => $directory . '/' . $filename
        ];
    }

    return null;
}


function oauthLogin($email, $password)
{
    $oauthClient = OAuthClient::orderBy('created_at', 'desc')->where('provider', 'users')->first();

    if (!$oauthClient) {
        return false;
    }

    $client = new Client();

    try {

        //$response =  $client->post('http://localhost/workflow-crm-api/public/v1/oauth/token', [
        $response =  $client->post(url('/v1/oauth/token'), [
            'form_params' => [
                'client_secret' => $oauthClient->secret,
                'client_id' => $oauthClient->id,
                'grant_type' => 'password',
                'username' => $email,
                'password' => $password
            ]
        ]);
        return $response;
    } catch (BadResponseException $e) {
        return $e;
    }


    return $oauthClient;
}
