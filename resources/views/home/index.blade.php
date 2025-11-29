<x-layout>
    <div class="py-5 d-flex justify-content-between">
        <h1 class="text-dark fs-3 fw-bold">Your Class</h1>
        <x-dropdown-class />
    </div>

    <x-modal-join />

    <div class="row gap-3 gap-md-0">
        @foreach ($classrooms as $classroom)
        <x-card-class :classroom="$classroom" />
        @endforeach
    </div>
</x-layout>