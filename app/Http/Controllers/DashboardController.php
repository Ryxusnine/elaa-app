<?php

namespace App\Http\Controllers;

use App\Models\InputData;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Redis\Connectors\PredisConnector;
use Phpml\Classification\SVC;
use Phpml\Dataset\ArrayDataset;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Tokenization\WordTokenizer;

class DashboardController extends Controller
{
    function preprocess($review) 
    { 
        // Langkah 1: Mengubah teks menjadi lowercase 
        $ulasan = strtolower($review); 
    
        // Langkah 2: Menghapus karakter khusus dan tanda baca 
        $ulasan = preg_replace('/[^a-zA-Z0-9\s]/', '', $ulasan); 
        // Menghapus karakter non-teks 
        $ulasan = preg_replace('/[^\p{L}\p{N}\s]/u', '', $ulasan); 
        // Menghapus tanda baca berlebih seperti "!!", "!!!", "??", "???", "...", dst. 
        $ulasan = preg_replace('/([.!?]){2,}/', '$1', $ulasan); 
    
        // Langkah 3: Tokenisasi - Memisahkan teks menjadi kata-kata 
        $kataKata = explode(" ", $ulasan); 
    
        // Langkah 4: Menghapus stop words (kata-kata yang tidak   relevan) 
        $stopWords = ["saya", "sangat", "aku", "dan", "di", "dari"]; 
        $kataKata = array_diff($kataKata, $stopWords); 
    
        // Langkah 5: menggabungkan kata-kata yang telah dibersihkan 
        $teksBersih = implode(" ", $kataKata); 
    
        return $teksBersih; 
    } 

    public function analisis(Request $request){
        $reviews = Review::all(); 
        $vectorizer = new TokenCountVectorizer(new WordTokenizer());
        $tfIdfTransformer = new TfIdfTransformer();
        
        $samples = [];
        $labels = [];
        
        foreach ($reviews as $review) {
            $samples[] = $this->preprocess($review->ulasan); 
            $labels[] = $review->sentimen;
        }

        $samples[] = $this->preprocess($request->ulasan);
        
        $vectorizer->fit($samples);
        $vectorizer->transform($samples);
        
        $tfIdfTransformer->fit($samples);
        $tfIdfTransformer->transform($samples);

        $requestTFID = $samples[count($samples) - 1];
        array_pop($samples);
        $dataset = new ArrayDataset($samples, $labels);
        $classifier = new SVC(Kernel::RBF, 10000);

        $classifier->train($dataset->getSamples(), $dataset->getTargets());
        $predictedLabels = $classifier->predict([$requestTFID]);
        $predictedLabels = $predictedLabels[0];

        $review = Review::where('ulasan', $request->ulasan)->first(); 
        if (!$review) { 
            $review = new Review();  
            $review->ulasan = $request->ulasan; 
            $review->sentimen = $request->sentimen;
            $review->analisis = strtolower($predictedLabels);
            $review->save(); 
        } else {
            $review->ulasan = $request->ulasan; 
            $review->sentimen = $request->sentimen;
            $review->analisis = strtolower($predictedLabels);
            $review->save(); 
        }

        return redirect()->route('dashboard.index')->with([
            'prediction' => [
                'analisis' => strtolower($predictedLabels),
                'ulasan' => $request->ulasan
            ]
        ]);
    }

    public function HalamanDashboard()
    {
        $sentimen = [
            'negative' => Review::whereNotNull('analisis')->where('sentimen', 'negative')->count(),
            'positive' => Review::whereNotNull('analisis')->where('sentimen', 'positive')->count(),
            'netral' => Review::whereNotNull('analisis')->where('sentimen', 'netral')->count(),
        ];

        $analisis = [
            'negative' => Review::whereNotNull('analisis')->where('analisis', 'negative')->count(),
            'positive' => Review::whereNotNull('analisis')->where('analisis', 'positive')->count(),
            'netral' => Review::whereNotNull('analisis')->where('analisis', 'netral')->count(),
        ];

        return view('dashboard',[
            'sentimen' => $sentimen,
            'analisis' => $analisis,
        ]);
    }

    public function HalamanUlasan()
    {
        $viewanalisis = Review::orderBy('created_at','DESC')->whereNotNull('analisis')->paginate(15);
        return view('ulasan', ['viewanalisis' => $viewanalisis]);
    }

    public function storeUlasan(Request $request)
    {
        InputData::create([
            'id_user' => '',
            'komentar' => $request->komentar,
            'sentimen' => $request->sentimen,
        ]);
        return redirect()->route('ulasan.index')->with('alert.berhasil', true);
    }

    public function HalamanAbout()
    {
        return view('about');
    }

    public function KritikDanSaran()
    {
        return view('kritikdansaran');
    }
}
