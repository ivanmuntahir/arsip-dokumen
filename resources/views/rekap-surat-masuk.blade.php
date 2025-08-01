<!DOCTYPE html>
<html>
<head>
    <title>Laporan Surat Masuk Persandian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        /* Basic styling for PDF */
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Laporan Surat Masuk Persandian</h1>
    <h1>Bulan : {{ $bulan }}</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>No Surat</th>
                <th>Tanggal Terima</th> {{-- Changed from Feedback Tanggal --}}
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach($laporans as $laporan)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $laporan->no_surat }}</td>
                    <td>{{ $laporan->tanggal_terima }}</td> {{-- Changed from feedback_date --}}
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
