<x-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="p-4 border rounded bg-white">
                    <h4 class="fw-bold mb-3 fs-5">Kebijakan & Perjanjian</h4>

                    <p class="text-muted fs-vs mb-2">
                        Dengan membuat kelas, Anda setuju untuk:
                    </p>

                    <ul class="text-muted fs-vs">
                        <li>Tidak menggunakan kelas untuk aktivitas negatif.</li>
                        <li>Tidak menyebarkan konten yang melanggar hukum.</li>
                        <li>Menjaga keamanan dan kenyamanan semua anggota kelas.</li>
                        <li>Bertanggung jawab penuh atas aktivitas dalam kelas.</li>
                    </ul>

                    <p class="text-muted fs-vs mt-3">
                        Dengan menekan tombol "Buat Kelas", Anda dianggap menyetujui semua ketentuan di atas.
                    </p>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="p-4 border bg-white rounded">
                    <form method="POST" action="{{ route('storeClass') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Kelas</label>
                            <textarea class="form-control" name="description" rows="4"></textarea>
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button class="btn btn-dark w-100 mt-2">
                            Buat Kelas
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-layout>