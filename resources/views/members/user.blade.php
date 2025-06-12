@extends('layout.user')
@section('content')
<div class="container form-container" style="overflow-x: hidden">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 p-lg-3">
            <form method="POST" action="{{ route('members.update', $member->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="remove_photo" id="remove-photo-flag" value="0">

                <div class="text-center p-4 pt-0 ">
                    <label
                        for="photo"
                        class="border-dark-gold p-1 font-playfair bg-body-secondary d-inline-block"
                        style="width: 160px; height: 160px; border-radius: 50%; cursor: pointer; position: relative;"
                        data-aos="zoom-in" data-aos-duration="700"
                    >
                        <img
                            id="preview-img"
                            src="{{ $member->photo && file_exists(public_path('images/' . $member->photo)) 
                                ? asset('images/' . $member->photo) 
                                : asset('images/default.png') }}"
                            alt="Preview"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"
                        />
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

                    <div class="mt-2">
                        <button
                            type="button"
                            id="remove-photo-btn"
                            class="btn btn-sm btn-outline-danger g-text-danger"
                            style="{{ $member->photo ? 'display:inline-block;' : 'display:none;' }}"
                            onclick="removePhoto()"
                            data-aos="zoom-in" data-aos-duration="400"
                        >Remove Photo</button>
                    </div>
                </div>

                <div class="w-100 mt-4">
                    <div data-aos="fade-left" data-aos-duration="500">
                        <x-input-text inRowLabel="Number" name="member_number" required="true" placeholder="Enter member number" value="{{ old('member_number') ?? $member->member_number }}" />
                    </div>
                    <div data-aos="fade-left" data-aos-duration="600">
                        <x-input-text inRowLabel="Name" name="name" required="true" placeholder="Enter name" value="{{ old('name') ?? ($member->user->name ?? '') }}" />
                    </div>
                    <div data-aos="fade-left" data-aos-duration="700">
                        <x-input-text inRowLabel="Email" name="email" required="true" placeholder="Enter email" value="{{ old('email') ?? ($member->user->email ?? '') }}" />
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
                </div>

                <div class="form-buttons mt-4 d-flex justify-content-center" data-aos="fade-left" data-aos-duration="1200">
                    <x-button type="submit">Update My Data</x-button>
                </div>
            </form>
        </div>
    </div>
    
</div>

<script>
function previewPhoto(event) {
    const input = event.target;
    const previewImg = document.getElementById('preview-img');
    const removeBtn = document.getElementById('remove-photo-btn');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        removeBtn.style.display = 'inline-block';
        document.getElementById('remove-photo-flag').value = "0";
    }
}

function removePhoto() {
    const input = document.getElementById('photo');
    const previewImg = document.getElementById('preview-img');
    const removeBtn = document.getElementById('remove-photo-btn');

    input.value = '';
    previewImg.src = "{{ asset('images/default.png') }}";
    removeBtn.style.display = 'none';
    document.getElementById('remove-photo-flag').value = "1";
}
</script>
<script>
    window.addEventListener('load', function () {
        AOS.init({
            once: true,
            mirror: false,
            offset: 0,
        });

        setTimeout(() => AOS.refresh(), 100);
    });
</script>
@endsection
