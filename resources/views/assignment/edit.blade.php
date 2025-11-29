<x-layout>
    <div class="mw-md py-4">
        <form action="{{ route('updateAssignment', ['id' => $id, 'id_post' => $post->id]) }}" method="post" enctype="multipart/form-data" id="edit-material-form">
            @csrf
            @method('PUT')

            <div class="card p-4 mb-3">
                <div class="mb-3">
                    <label class="form-label">Judul tugas</label>
                    <input type="text" name="title" value="{{ $post->title }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tenggat</label>
                    <input type="date" name="due" value="{{ $post->due }}" class="form-control @error('due') is-invalid @enderror">
                    @error('due')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Petunjuk</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="4" placeholder="Petunjuk pengerjaan..">{{ $post->content }}</textarea>
                    @error('content')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="card p-4 mb-3">
                <label class="form-label">Lampiran Lama</label>
                <div id="existing-files" class="mb-3">
                    @foreach($post->postFile as $file)
                    <x-card-file :file="$file" :deleted="true" />
                    @endforeach
                </div>

                <hr>
                <div id="file-preview" class="mt-3"></div>

                <div class="mb-3">
                    <label class="form-label">Tambah Lampiran</label>
                    <input type="file" name="files[]" multiple class="form-control" id="file-input">
                </div>
            </div>

            <div class="w-100 d-flex justify-content-end">
                <button class="btn btn-dark mt-3">Update</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('/scripts') }}/preview.js"></script>
    <script>
        document.querySelectorAll('.delete-file-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const fileDiv = this.closest('[data-id]');
                const fileId = fileDiv.dataset.id;

                if (!confirm("Yakin hapus file ini?")) return;
                const baseUrl = "{{ route('deletePostFile', ['id' => $id, 'id_file' => '__ID__']) }}";
                const url = baseUrl.replace('__ID__', fileId);
                const res = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                if (res.ok) fileDiv.remove();
            });
        });
    </script>
</x-layout>