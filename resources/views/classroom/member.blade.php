<x-layout>
    <div class="mw-md py-4">
        <h2 class="fs-5 fw-bold">Pengajar</h2>
        <ul class="list-group mt-3">
            <li class="list-group-item">
                <x-card-member :member="$author" :isAuthor="false" />
            </li>
        </ul>
        <h2 class="fs-5 fw-bold mt-5">Teman Kelas</h2>
        <ul class="list-group mt-3">
            @foreach ($members as $member)
            <li class="list-group-item">
                <x-card-member :member="$member" :isAuthor="$isAuthor" :id="$id" />
            </li>
            @endforeach
        </ul>
    </div>
</x-layout>