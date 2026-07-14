@extends('layouts.admin', ['title' => 'Mulai Perhitungan TOPSIS'])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Hitung TOPSIS</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary">Form Perhitungan Baru</h6>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Sistem akan mengambil data pengukuran <strong>terbaru</strong> untuk setiap gardu dalam rentang periode yang dipilih.
                </div>

                <form action="{{ route('topsis.calculate') }}" method="POST">
                    @csrf
                    <div class="row align-items-center mb-4">
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Dari Tanggal</label>
                            <input type="date" name="periode_mulai" class="form-control" value="{{ old('periode_mulai', date('Y-m-01')) }}" required>
                        </div>
                        <div class="col-md-1 text-center mt-3">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Sampai Tanggal</label>
                            <input type="date" name="periode_selesai" class="form-control" value="{{ old('periode_selesai', date('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Catatan (Optional)</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Perhitungan rutin triwulan I 2025"></textarea>
                    </div>

                    <div class="d-grid shadow-sm">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-play me-2"></i> Jalankan Perhitungan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-secondary">Informasi Metode TOPSIS</h6>
            </div>
            <div class="card-body">
                <p>Technique for Others Preference by Similarity to Ideal Solution (TOPSIS) didasarkan pada konsep bahwa alternatif terbaik tidak hanya memiliki jarak terpendek dari solusi ideal positif, tetapi juga memiliki jarak terpanjang dari solusi ideal negatif.</p>
                <ul class="small text-muted">
                    <li><strong>Matriks Keputusan (X):</strong> Nilai mentah dari kriteria yang dipilih.</li>
                    <li><strong>Normalisasi & Terbobot (R & Y):</strong> Penyesuaian skala nilai (vektor) dan perkalian dengan bobot kriteria.</li>
                    <li><strong>Solusi Ideal & Jarak (A+, A-, D+, D-):</strong> Penentuan jarak setiap alternatif terhadap solusi ideal.</li>
                    <li><strong>Preferensi (V):</strong> Hasil akhir (D- / (D+ + D-)) yang menentukan ranking alternatif.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
