@extends('layout.main')
@section('title', 'Edit Member')
@section('content')
<div class="container form-container" style="overflow-x: hidden">
    <form method="POST" action="{{ route('members.update', $member->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="remove_photo" id="remove-photo-flag" value="0">

        <div class="d-flex justify-content-between align-items-center flex-lg-row flex-column align-items-lg-start">
            <div class="text-center p-4 pt-0 d-flex flex-column justify-content-center align-items-center" data-aos="fade-right" data-aos-duration="500">
                <label
                    for="photo"
                    class="text-center border-dark-gold p-3 font-playfair bg-body-secondary d-flex flex-column align-items-center justify-content-between"
                    style="width: 140px; height: 210px; display: inline-block; cursor: pointer; position: relative;"
                >
                    <img
                        id="preview-img"
                        src="{{ $member->photo && file_exists(public_path('images/' . $member->photo)) 
                                ? asset('images/' . $member->photo) 
                                : asset('images/default.png') }}"
                        alt="Preview"
                        style="width:100%; height:120px; object-fit:cover; border-radius:4px;"
                    />

                    <div id="photo-preview" class="mt-2 text-center">
                        <div class="main-color" id="photo-instruction">Click to upload photo</div>
                    </div>
                </label>

                <input
                    type="file"
                    name="photo"
                    id="photo"
                    class="d-none"
                    accept="image/*"
                    onchange="previewPhoto(event)"
                />

                @error('photo')
                    <div class="g-text-danger font-playfair mt-1">{{ $message }}</div>
                @enderror

                <button
                    type="button"
                    id="remove-photo-btn"
                    class="btn btn-sm btn-outline-danger mt-2 g-text-danger"
                    style="{{ $member->photo ? 'display:inline-block;' : 'display:none;' }}"
                    onclick="removePhoto()"
                >Remove File</button>
            </div>

            <div class="w-100">
                <div data-aos="fade-left" data-aos-duration="400">
                    <x-input-text inRowLabel="Number" name="member_number" required="true" placeholder="Enter member number" value="{{ old('member_number') ?? $member->member_number }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="500">
                    <x-input-text inRowLabel="Name" name="name" required="true" placeholder="Enter name" value="{{ old('name') ?? ($member->user->name ?? '') }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="600">
                    <x-input-text inRowLabel="Email" name="email" required="true" placeholder="Enter email" value="{{ old('email') ?? ($member->user->email ?? '') }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="700">
                    @php 
                    use Carbon\Carbon; 
                    $dateofbirth = old('date_of_birth') ?: $member->date_of_birth; 
                    $dateofbirth = $dateofbirth ? Carbon::parse($dateofbirth)->format('Y-m-d') : ''; 
                    @endphp
                </div>
                <div data-aos="fade-left" data-aos-duration="800">
                    <x-input-text inRowLabel="Date of Birth" name="date_of_birth" type="date" required="true" value="{{ $dateofbirth }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="900">
                    <x-input-option label="Gender" name="gender" type="select" :options="['F' => 'Female','M' => 'Male']" required="true" placeholder="Select gender" :value="old('gender', $member->gender)" />
                </div>
                <div data-aos="fade-left" data-aos-duration="1000">
                    <x-input-text-area label="Address" name="address" type="textarea" rows="3" required="true" placeholder="Enter address" value="{{ old('address') ?? $member->address }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="1100">
                    <x-input-text inRowLabel="Handphone" name="handphone" required="true" placeholder="Enter handphone" value="{{ old('handphone') ?? $member->handphone }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="1200">
                    <x-input-text inRowLabel="Employment" name="employment" required="true" placeholder="Enter employment" value="{{ old('employment') ?? $member->employment }}" />
                </div>

                <div class="form-buttons mt-4 d-flex justify-content-between" data-aos="fade-left" data-aos-duration="1300">
                    <x-dark-button href="{{ route('members.index') }}">
                        <i class="bi bi-arrow-left"></i> Back
                    </x-dark-button>
                    <x-button type="submit">Update Member</x-button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewPhoto(event) {
    const input = event.target;
    const previewImg = document.getElementById('preview-img');
    const instruction = document.getElementById('photo-instruction');
    const removeBtn = document.getElementById('remove-photo-btn');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);

        if (instruction) instruction.style.display = 'none';
        if (removeBtn) removeBtn.style.display = 'inline-block';
        document.getElementById('remove-photo-flag').value = "0";
    }
}

function removePhoto() {
    const input = document.getElementById('photo');
    const previewImg = document.getElementById('preview-img');
    const instruction = document.getElementById('photo-instruction');
    const removeBtn = document.getElementById('remove-photo-btn');

    input.value = '';
    previewImg.src = "{{ asset('images/default.png') }}";
    if (instruction) instruction.style.display = '';
    if (removeBtn) removeBtn.style.display = 'none';
    document.getElementById('remove-photo-flag').value = "1";
}
</script>
@endsection
