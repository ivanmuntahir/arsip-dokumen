<!DOCTYPE html>
<html>
<head>
    <title>Laporan Surat Masuk</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> --}}
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1, h2 { text-align: center; margin-bottom: 10px; }
    
       
        .footer {
            margin-top: 30px; /* Jarak dari konten di atasnya */
            display: flex; /* Aktifkan Flexbox di footer utama */
            align-items: flex-end; /* <-- Ini akan menempatkan semua item di bagian bawah kontainer footer */
            justify-content: space-between; /* <-- Ini akan memisahkan item kiri dan kanan */
            font-size: 10px;
            color: #555;
            padding: 5px 0;
            border-top: 1px solid #eee; /* Garis pemisah di atas footer */
        }

        .footer .footer-left-content {
            display: flex; /* Aktifkan Flexbox untuk menumpuk teks secara vertikal */
            flex-direction: column; /* <-- Ini yang membuat teks bertumpuk */
            align-items: flex-start; /* Mengatur teks agar rata kiri dalam kolomnya */
            margin: 0;
            padding: 0;
        }

        .footer .footer-right-content {
            /* Tidak perlu display: flex di sini karena hanya ada satu item (gambar) */
            /* align-self: flex-end; /* Opsional: Jika ingin memastikan kontainer ini menempel ke bawah, tapi align-items di induk sudah cukup */
            margin: 0;
            padding: 0;
            display:flex;
             align-items: flex-end;
        }

        .footer .logo-footer {
            width: 80px;   /* Atur ukuran lebar logo yang Anda inginkan (sesuaikan) */
            height: 80px;  /* Jaga rasio aspek */
            margin: 0;     /* Pastikan tidak ada margin yang mendorong logo */
            padding: 0;
        }

        .footer .footer-left-content span {
            margin: 0; /* Pastikan tidak ada margin yang membuat jarak antar baris teks */
            padding: 0;
            line-height: 1.2; /* Atur tinggi baris untuk kerapatan teks yang bertumpuk */
        }
        
    </style>
</head>
<body>
    <h1>LAPORAN REKAPITULASI SURAT PERSANDIAN</h1>
    <h2>{{ $subtitle ?? 'Rekap Surat Masuk' }}</h2> {{-- Menggunakan subtitle dari controller --}}

    @if(isset($start_date) && isset($end_date))
        <p style="text-align: center;">Periode: {{ date('d-m-Y', strtotime($start_date)) }} s/d {{ date('d-m-Y', strtotime($end_date)) }}</p>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>No Surat</th>
                <th>Instansi Pengirim</th>
                <th>Tanggal Terima</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @forelse($laporans as $laporan)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $laporan->no_surat }}</td>
                    <td>
                        @if($laporan->pengirim->isNotEmpty())
                            {{ $laporan->pengirim->pluck('nama')->implode(', ') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ date('d-m-Y', strtotime($laporan->tanggal_terima)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data surat masuk untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
   
    <div class="footer">
        <div class="footer-left-content">
            <span>Diunduh dari Sistem Informasi Arsip Persandian (SIAP)</span>
            <br> 
            <span> {{ $download_timestamp ?? '' }}</span>
        </div>
        {{-- <div class="footer-right-content">
            
            @if(isset($logo_base64) && $logo_base64)
                <img src="{{ $logo_base64 }}" alt="Logo SIAP" class="logo-footer">
            @else
                <span>Logo SIAP</span> @endif
        </div> --}}
    </div>

</body>
</html>
