<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Lowongan;
use DOMDocument;



class HomeController extends Controller
{
    public function index()
    {
        $title = 'Beranda';
        $lowongan = Lowongan::where('expired_at', '>=', now()->subDays(30))
                        ->orderBy('expired_at', 'desc')
                        ->get();
                        
        foreach ($lowongan as $item) {
            // Parse the description HTML
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($item->description);
            libxml_clear_errors();
    
            // Find all list items (li elements)
            $listItems = [];
            foreach ($doc->getElementsByTagName('li') as $li) {
                $listItems[] = $li->textContent;
            }
    
            // Split the list into two parts
            $splitIndex = ceil(count($listItems) / 2);
            $item->descriptionPart1 = array_slice($listItems, 0, $splitIndex);
            $item->descriptionPart2 = array_slice($listItems, $splitIndex);
        }

        $guideLink = env('GOOGLE_DRIVE_USER_GUIDE');
        return view('home', [
            'lowongan' => $lowongan,
            'guideLink' => $guideLink
        ]);
    }
}
