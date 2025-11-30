@props(['post', 'classroom', 'isAuthor'])

<div class="card px-4 py-2">
    <div class="d-flex gap-3 align-items-start">
        <img class="rounded-circle object-fit-cover mt-3"
            width="40"
            height="40"
            src="{{ $post->user->photo }}">

        <div class="mt-3">
            @if($post->type === 'information')
            <p class="fs-vs fw-bold">
                {{ $post->user->firstname . ' ' . $post->user->lastname }}
            </p>
            @elseif($post->type === 'assignment')
            <p class="fs-vs fw-bold">Tugas: {{ $post->title }}</p>
            @else
            <p class="fs-vs fw-bold">{{ $post->title }}</p>
            @endif

            <p style="margin-top: -20px;" class="fs-vs text-muted">
                {{ $post->created_at->format('d M Y') }}
            </p>

            @if($post->type === 'information')
            <p class="fs-vs">{{ $post->content }}</p>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-between border-top" style="margin-left: 57px;">
        <a class="fs-vs" href="{{ route('detailPost', [$classroom->id, $post->id]) }}">
            Selengkapnya
        </a>

        @if($isAuthor)
        <div class="d-flex align-items-center gap-2">

            @if($post->type === 'assignment')
            <a class="fs-vs text-dark text-decoration-none" href="{{ route('editAssignment', ['id' => $classroom->id, 'id_post' => $post->id]) }}">Edit</a>
            @elseif($post->type === 'material')
            <a class="fs-vs text-dark text-decoration-none"
                href="{{ route('editMaterial', ['id' => $classroom->id, 'id_post' => $post->id]) }}">
                Edit
            </a>
            @else
            <a class="fs-vs text-dark text-decoration-none"
                data-bs-toggle="modal"
                data-bs-target="#editInformation{{ $post->id }}">
                Edit
            </a>
            @endif

            <form action="{{ route('deletePost', ['id' => $classroom->id, 'id_post' => $post->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Yakin untuk dihapus?')" class="border-0 bg-white fs-vs text-muted">
                    Delete
                </button>
            </form>

        </div>
        @endif
    </div>
</div>