<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Drive;
use League\Csv\Reader;


class GoogleController extends Controller
{
    public function spreadsheet() {

      $client = new Google_Client();
      putenv('GOOGLE_APPLICATION_CREDENTIALS=..path/to/your/json/file.json');
      $client->useApplicationDefaultCredentials();
      $client->addScope(Google_Service_Drive::DRIVE);

      $driveService = new Google_Service_Drive($client);

      // List Files
      // $response = $driveService->files->listFiles();

      // Set File ID and get the contents of your Google Sheet
      $fileID = 'YOUR-FILE-ID';
      $response = $driveService->files->export($fileID, 'text/csv', array(
            'alt' => 'media'));
      $content = $response->getBody()->getContents();

      // Create CSV from String
      $csv = Reader::createFromString($content, 'r');
      $csv->setHeaderOffset(0);
      $records = $csv->getRecords();

      // Create an Empty Array and Loop through the Records
      $newarray = array();
      foreach ($records as $value) {
          $newarray[] = $value;
      }

      // Dump and Die
      dd($newarray);

    }

}
