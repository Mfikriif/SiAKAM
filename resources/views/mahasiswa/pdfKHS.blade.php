<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print KHS</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            line-height: 1.6;
        }
        .header, .footer {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        .timestamp {
            text-align: left;
            margin-bottom: -20px;
            font-size: 10px;
            color: gray;
        }
        .signature-container {
            margin-top: 40px;
            margin-left: 70px
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
         }
        .left-signature {
            text-align: left;
            width: 40%;
        }
        .right-signature {
            text-align: right;
            width: 40%;
            margin-left: 420px;
            margin-top: -250px;
        }
    </style>
</head>
<body>
    <div class="timestamp">
        {{ \Carbon\Carbon::now()->format('d/m/Y, H:i:s') }}
    </div>

    <div class="header">
        <h3>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</h3>
        <h4>FAKULTAS SAINS DAN MATEMATIKA</h4>
        <h4>UNIVERSITAS DIPONEGORO</h4>
        <h2>KARTU HASIL STUDI</h2>
        <p>Semester Ganjil TA 2024/2025</p>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
        <div style="flex: 1;">
            <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
            <p><strong>Nama Mahasiswa:</strong> {{ $mahasiswa->nama }}</p>
            <p><strong>Program Studi:</strong> {{ $mahasiswa->jurusan }}</p>
            <p><strong>Dosen Wali:</strong> {{ $mahasiswa->Dosenwali->nama ?? '-' }}</p>
        </div>

        <div style="flex: 0 0 auto; margin-left: 20px; text-align: right; display: flex; justify-content: flex-end;">
            <img 
                 src="{{ $image }}" 
                 alt="User Photo"
                 style="width: 90px; height: 120px; object-fit: cover; border: 1px solid #000;">
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>KODE</th>
                <th>MATA KULIAH</th>
                <th>SKS</th>
                <th>Nilai Huruf</th>
                <th>Nilai Angka</th>
            </tr>
        </thead>
        <tbody>
            @foreach($khsData as $index => $khs)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $khs->kode_mk }}</td>
                <td>{{ $khs->mataKuliah->nama_mk }}</td>
                <td>{{ $khs->mataKuliah->sks }}</td>
                <td>{{ $khs->nilai_huruf ?? '-' }}</td>
                <td>{{ $khs->nilai_angka ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>IP Semester : </p>

    <div class="signature-container">
        <!-- Bagian Pembimbing Akademik -->
        <div class="left-signature" style="text-align: left; width: 40%;">
            <p>Pembimbing Akademik (Dosen Wali)</p>
            <br><br><br> <!-- Spasi untuk tanda tangan -->
            <p>{{ $mahasiswa->Dosenwali->nama ?? '-' }}<br>
                {{ $mahasiswa->Dosenwali->nip ?? '-' }}</p>
        </div>
        <!-- Bagian Tanda Tangan Mahasiswa -->
        <div class="right-signature" style="text-align: right; width: 40%;">
            <p>Semarang, {{ date('d F Y') }}</p>
            <p>Nama Mahasiswa,</p>
            <br><br><br> <!-- Spasi untuk tanda tangan -->
            <p>{{ $mahasiswa->nama }}<br>
            NIM. {{ $mahasiswa->nim }}</p>
        </div>
    </div>
    
</body>
</html>
