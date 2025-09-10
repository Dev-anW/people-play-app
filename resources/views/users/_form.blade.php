{{-- Name --}}
<div class="col-xs-12 col-sm-12 col-md-6">
    <div class="form-group">
        <strong>Name:</strong>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" placeholder="Name" >
    </div>
</div>

{{-- Surname --}}
<div class="col-xs-12 col-sm-12 col-md-6">
    <div class="form-group">
        <strong>Surname:</strong>
        <input type="text" name="surname" value="{{ old('surname', $user->surname ?? '') }}" class="form-control" placeholder="Surname">
    </div>
</div>

{{-- Email Address --}}
<div class="col-xs-12 col-sm-12 col-md-6 mt-3">
    <div class="form-group">
        <strong>Email Address:</strong>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" placeholder="Email Address" >
    </div>
</div>

{{-- Mobile Number --}}
<div class="col-xs-12 col-sm-12 col-md-6 mt-3">
    <div class="form-group">
        <strong>Mobile Number:</strong>
        <input type="text" name="mobile_number" value="{{ old('mobile_number', $user->mobile_number ?? '') }}" class="form-control" placeholder="Mobile Number" >
    </div>
</div>

{{-- South African ID Number --}}
<div class="col-xs-12 col-sm-12 col-md-6 mt-3">
    <div class="form-group">
        <strong>South African ID Number:</strong>
        <input type="text" name="sa_id_number" value="{{ old('sa_id_number', $user->sa_id_number ?? '') }}" class="form-control" placeholder="13-digit SA ID" >
    </div>
</div>

{{-- Birth Date --}}
<div class="col-xs-12 col-sm-12 col-md-6 mt-3">
    <div class="form-group">
        <strong>Birth Date:</strong>
        <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date ?? '') }}" class="form-control" >
    </div>
</div>

{{-- Language --}}
<div class="col-xs-12 col-sm-12 col-md-12 mt-3">
    <div class="form-group">
        <strong>Language:</strong>
        <select name="language" class="form-control">
            <option value="">-- Select Language --</option>
            @php
                $languages = ['English', 'Afrikaans', 'Zulu', 'Xhosa', 'Sotho'];
                $selectedLanguage = old('language', $user->language ?? '');
            @endphp
            @foreach ($languages as $language)
                <option value="{{ $language }}" {{ $selectedLanguage == $language ? 'selected' : '' }}>
                    {{ $language }}
                </option>
            @endforeach
        </select>
    </div>
</div>

{{-- Interests --}}
<div class="col-xs-12 col-sm-12 col-md-12 mt-3">
    <div class="form-group">
        <strong>Interests:</strong><br/>
        @foreach ($interests as $interest)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="interests[]" value="{{ $interest->id }}"
                    @if(in_array($interest->id, old('interests', $userInterests ?? []))) checked @endif>
                <label class="form-check-label">{{ $interest->name }}</label>
            </div>
        @endforeach
    </div>
</div>