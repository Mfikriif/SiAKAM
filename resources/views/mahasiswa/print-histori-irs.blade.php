<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori IRS</title>
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
    <div class="header">
        <h3>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</h3>
        <h4>UNIVERSITAS DIPONEGORO</h4>
        <h4>FAKULTAS SAINS DAN MATEMATIKA</h4>
        <h2>HISTORI IRS</h2>
    </div>

    <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
    <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
    <p><strong>Program Studi:</strong> {{ $mahasiswa->jurusan }}</p>

    @foreach ($groupedHistori as $tahunAjaran => $irsItems)
        <h3>Tahun Ajaran: {{ $tahunAjaran }}</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Semester</th>
                    <th>Kode MK</th>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($irsItems as $index => $irs)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $irs->semester }}</td>
                        <td>{{ $irs->kode_mk }}</td>
                        <td>{{ $irs->nama_mk }}</td>
                        <td>{{ $irs->sks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
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