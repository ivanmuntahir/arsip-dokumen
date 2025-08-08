<?php

namespace App\Http\Controllers;

use App\Models\IncomingMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PDFController extends Controller
{
    public function downloadpdf(){
        $laporans = IncomingMail::select('tanggal_terima', 'no_surat')->get();

        $data = [
            'title' => 'Rekap Surat Masuk',
            'laporans' => $laporans,
        ];

        $pdf = Pdf::loadView('rekap-surat-masuk', $data);
        return $pdf->download('rekap-surat-masuk.pdf');
    }

    public function downloadpdfFiltered(Request $request){
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $laporans = IncomingMail::with('pengirim')
                                ->whereBetween('tanggal_terima', [$startDate, $endDate])
                                ->get();

        $totalSurat = $laporans->count();

        $logoPath = storage_path('app/public/assets/images/logo.png');
        $logoBase64 = null;

        if (File::exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $data = File::get($logoPath);
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {

            Log::error("Logo file not found at: " . $logoPath);

        }

        $subTitle = 'Total Surat Masuk: ' . $totalSurat . ' Surat';
        $downloadTimestamp = 'Diunduh pada: ' . date('H:i') . ' WIB, ' . date('d-m-Y');

        $data = [
            'title' => 'Rekap Surat Masuk Periode ' . $startDate . ' s/d ' . $endDate,
            'subtitle' => $subTitle,
            'laporans' => $laporans,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'download_timestamp' => $downloadTimestamp,
            'logo_path' => $logoPath,
            'logo_base64' => $logoBase64,
        ];

        $pdf = Pdf::loadView('rekap-surat-masuk-filtered', $data);
        return $pdf->download('rekap-surat-masuk_' . $startDate . '_to_' . $endDate . '.pdf');
    }
}
