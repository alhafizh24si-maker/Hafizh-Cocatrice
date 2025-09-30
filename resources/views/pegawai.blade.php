<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.5;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .data-item {
            margin-bottom: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            color: #555;
        }
        .hobby-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .hobby-list li {
            margin: 5px 0;
            padding: 5px 0;
        }
        .motivasi {
            background-color: #f5f5f5;
            padding: 10px;
            margin: 15px 0;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Pegawai</h1>

        <div class="data-item">
            <span class="label">Nama:</span>
            <span class="value">{{ $name }}</span>
        </div>

        <div class="data-item">
            <span class="label">Umur:</span>
            <span class="value">{{ $my_age }} tahun</span>
        </div>

        <div class="data-item">
            <span class="label">Hobi:</span>
            <ul class="hobby-list">
                @foreach($hobbies as $hobby)
                    <li>{{ $hobby }}</li>
                @endforeach
            </ul>
        </div>
 
        <div class="data-item">
            <span class="label">Tanggal Harus Wisuda:</span>
            <span class="value">{{ $tgl_harus_wisuda }}</span>
        </div>

        <div class="data-item">
            <span class="label">Jumlah Hari Menuju Wisuda:</span>
            <span class="value">
                @if($time_to_study_left >= 0)
                    {{ $time_to_study_left }} hari lagi
                @else
                    Sudah lewat {{ abs($time_to_study_left) }} hari
                @endif
            </span>
        </div>

        <div class="data-item">
            <span class="label">Semester Saat Ini:</span>
            <span class="value">Semester {{ $current_semester }}</span>
        </div>

        <div class="motivasi">
            <strong>Pesan Motivasi:</strong><br>
            {{ $semester_message }}
        </div>

        <div class="data-item">
            <span class="label">Cita-cita:</span>
            <span class="value">{{ $future_goal }}</span>
        </div>
    </div>
</body>
</html>
