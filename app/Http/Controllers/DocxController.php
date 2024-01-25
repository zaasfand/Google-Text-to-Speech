<?php

namespace App\Http\Controllers;
use PhpOffice\PhpWord\IOFactory;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class DocxController extends Controller
{
    public function processDocx(Request $request)
    {
        try {
            $request->validate([
                'docx_file' => 'required|mimes:docx|max:10240', // Adjust max file size as needed
                'language' => 'required|in:da-DK,en-US,nl-NL,fa-IR,hu-HU,fi-FI,id-ID,it-IT,sv-SE,tr-TR', // Adjust language options as needed
            ]);
    
            $file = $request->file('docx_file');
            $language = $request->input('language');
            $fileName =  explode('.',$file->getClientOriginalName())[0];
            // dd($fileName);
    
            // Extract text from the DOCX file
            $text = $this->extractTextFromDocx($file);
    
            // Convert text to array
            $textInArray = $this->textToArray($text);
    
            // Generate audio using text-to-speech
            $audioContent = $this->generateAudio($textInArray, $language,$fileName);
    
            // Save or stream the audio as needed
            // For example, save to a file:
            // file_put_contents('path/to/audio/output.wav', $audioContent);
    
            return redirect()->back()->with('success', 'Audio generated successfully.');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    private function extractTextFromDocx($file)
    {
        $phpWord = IOFactory::load($file->getRealPath());
        $text = '';

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    $text .= $element->getText();
                }
            }
        }

        return $text;
    }
    public function textToArray($text) {
        // Split the text into sentences based on the numbering pattern
        $sentences = preg_split('/\d+- /', $text, -1, PREG_SPLIT_NO_EMPTY);
    
        // Remove any leading or trailing whitespaces
        $sentences = array_map('trim', $sentences);
    
        return $sentences;
    }


    private function generateAudio($textInArray, $language, $languagename)
    {
        try {
            // Get the public path
            $publicPath = public_path();
    
            // Create a folder for today's date
            $dateFolder = now()->format('Y-m-d');
            $dateFolderPath = "$publicPath/$dateFolder";
            File::makeDirectory($dateFolderPath, 0777, true, true);
    
            foreach ($textInArray as $key => $text) {
                $curl = curl_init();
                $payload = [
                    'input' => ["text"=> $text],
                    "voice"=> [
                        "languageCode" => $language,
                        "name"=> "en-US-Wavenet-D",
                        "ssmlGender"=> "NEUTRAL"
                    ],
                    "audioConfig" => ["audioEncoding"=> "LINEAR16"]
                ];
    
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://texttospeech.googleapis.com/v1/text:synthesize?key=Your-API-Key',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($payload),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                    CURLOPT_SSL_VERIFYPEER => false,
                ));
    
                $response = curl_exec($curl);
                curl_close($curl);
    
                // Decode the base64-encoded audio content
                $audioData = json_decode($response, true)['audioContent'];
                $decodedAudio = base64_decode($audioData);

                // Create a folder for the language inside the date folder
                $languageFolder = "$dateFolderPath/$languagename";
                File::makeDirectory($languageFolder, 0777, true, true);

                // Save the decoded audio data as a binary file
                $filename = "audio_$key.wav";
                $audioPath = "$languageFolder/$filename";
                File::put($audioPath, $decodedAudio);

                // You can do something with $audioPath if needed
                echo "Audio file saved at: $audioPath\n";
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
    
}
