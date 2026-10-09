<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class ResumeController extends Controller
{
    public function index()
    {
        // Fetch the student's uploaded resumes from the database
        $documents = Document::where('user_id', auth()->id())
                             ->where('document_type', 'resume')
                             ->latest('uploaded_at')
                             ->get();
                             
        return view('student.resume', compact('documents'));
    }

    public function store(Request $request){
        //validate uploaded pdf
        $request->validate([
            'resume' => 'required|mimes:pdf|max:5120',
        ]);

        //store the file in storage
        $file = $request->file('resume');
        $path = $file->store('resumes', 'local');

        //parse raw text from pdf
        $pdfParser = new Parser();
        $pdf = $pdfParser->parseFile(Storage::disk('local')->path($path));
        $text = $pdf->getText();

        //send the text to the API for match
        try {
            $nlpUrl = env('NLP_SERVICE_URL', 'http://nlp-service:5000') . '/extract';
            $response = Http::post($nlpUrl, ['resume_text' => $text]);

            if($response->successful()){
                $nlpData = $response->json();
                $extractedSkills = $nlpData['skills'] ?? [];
            }
            else {
                return back()->with('error', 'NLP API returned an error:' . $response->body());
            }
        }
        catch (\Exception $e){
            return back()->with('error', 'Failed to connect to the NLP microservice: ' . $e->getMessage());
        }

        //save the JSON into the database table
        Document::create([
            'user_id' => auth()->id(),
            'application_id' => null,
            'document_type' => 'resume',
            'file_path' => $path,
            'parsed_data' => $extractedSkills
        ]);

        return back()->with('success', 'Resume uploaded and skills extracted successfully.');
    }
}
