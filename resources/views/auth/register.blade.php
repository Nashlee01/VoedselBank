@extends('layouts.guest')

@section('content')
<div class="container-centered">
    <div class="container-centered-form">
        <h1>Account aanmaken</h1>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/register" method="POST">
            @csrf

            <div class="form-container">
                <label for="gezinsnaam" class="form-label">Gezinsnaam *</label>
                <input type="text" name="gezinsnaam" id="gezinsnaam" value="{{ old('gezinsnaam') }}" required class="form-input" />
            </div>

            <div class="form-container">
                <label for="straat" class="form-label">Straat *</label>
                <input type="text" name="straat" id="straat" value="{{ old('straat') }}" required class="form-input" />
            </div>

            <div class="form-container">
                <label for="huisnummer" class="form-label">Huisnummer *</label>
                <input type="text" name="huisnummer" id="huisnummer" value="{{ old('huisnummer') }}" required class="form-input" />
            </div>

            <div class="form-container">
                <label for="toevoeging" class="form-label">Toevoeging</label>
                <input type="text" name="toevoeging" id="toevoeging" value="{{ old('toevoeging') }}" class="form-input" />
            </div>

            <div class="form-container">
                <label for="postcode" class="form-label">Postcode *</label>
                <input type="text" name="postcode" id="postcode" value="{{ old('postcode') }}" required class="form-input" />
            </div>

            <div class="form-container">
                <label for="plaats" class="form-label">Plaats *</label>
                <input type="text" name="plaats" id="plaats" value="{{ old('plaats') }}" required class="form-input" />
            </div>

            <div class="form-container">
                <label for="telefoonnummer" class="form-label">Telefoonnummer *</label>
                <input type="text" name="telefoonnummer" id="telefoonnummer" value="{{ old('telefoonnummer') }}" required class="form-input" />
            </div>

            <div class="form-container">
                <label for="email" class="form-label">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="form-input" />
            </div>

            @php
                $adultDates = old('geboortedata_volwassenen', []);
                $adultCount = old('aantal_volwassenen', 0);
                $childDates = old('geboortedata_kinderen', []);
                $childCount = old('aantal_kinderen', 0);
                $babyDates = old('geboortedata_babys', []);
                $babyCount = old('aantal_babys', 0);
            @endphp

            <div class="form-container">
                <label for="aantal_volwassenen" class="form-label">Aantal volwassenen *</label>
                <input type="number" min="0" name="aantal_volwassenen" id="aantal_volwassenen" value="{{ $adultCount }}" required class="form-input" />
            </div>

            <div id="adult-dates-wrapper" class="form-group" style="display: {{ $adultCount > 0 ? 'block' : 'none' }};">
                <label class="form-label">Geboortedata van de volwassenen</label>
                <div id="adult-dates-container">
                    @for ($i = 0; $i < $adultCount; $i++)
                        <div class="form-container">
                            <label for="geboortedata_volwassenen_{{ $i }}" class="form-label">Geboortedatum volwassene {{ $i + 1 }} *</label>
                            <input type="date" name="geboortedata_volwassenen[]" id="geboortedata_volwassenen_{{ $i }}" value="{{ $adultDates[$i] ?? '' }}" required class="form-input" />
                        </div>
                    @endfor
                </div>
            </div>

            <div class="form-container">
                <label for="aantal_kinderen" class="form-label">Aantal kinderen *</label>
                <input type="number" min="0" name="aantal_kinderen" id="aantal_kinderen" value="{{ $childCount }}" required class="form-input" />
            </div>

            <div id="child-dates-wrapper" class="form-group" style="display: {{ $childCount > 0 ? 'block' : 'none' }};">
                <label class="form-label">Geboortedata van de kinderen</label>
                <div id="child-dates-container">
                    @for ($i = 0; $i < $childCount; $i++)
                        <div class="form-container">
                            <label for="geboortedata_kinderen_{{ $i }}" class="form-label">Geboortedatum kind {{ $i + 1 }} *</label>
                            <input type="date" name="geboortedata_kinderen[]" id="geboortedata_kinderen_{{ $i }}" value="{{ $childDates[$i] ?? '' }}" required class="form-input" />
                        </div>
                    @endfor
                </div>
            </div>

            <div class="form-container form-last">
                <label for="aantal_babys" class="form-label">Aantal baby’s *</label>
                <input type="number" min="0" name="aantal_babys" id="aantal_babys" value="{{ $babyCount }}" required class="form-input" />
            </div>

            <div id="baby-dates-wrapper" class="form-group" style="display: {{ $babyCount > 0 ? 'block' : 'none' }};">
                <label class="form-label">Geboortedata van de baby’s</label>
                <div id="baby-dates-container">
                    @for ($i = 0; $i < $babyCount; $i++)
                        <div class="form-container">
                            <label for="geboortedata_babys_{{ $i }}" class="form-label">Geboortedatum baby {{ $i + 1 }} *</label>
                            <input type="date" name="geboortedata_babys[]" id="geboortedata_babys_{{ $i }}" value="{{ $babyDates[$i] ?? '' }}" required class="form-input" />
                        </div>
                    @endfor
                </div>
            </div>

            <script>
                (function() {
                    const sections = [
                        {
                            countInputId: 'aantal_volwassenen',
                            wrapperId: 'adult-dates-wrapper',
                            containerId: 'adult-dates-container',
                            fieldName: 'geboortedata_volwassenen[]',
                            fieldId: 'geboortedata_volwassenen_',
                            fieldLabelPrefix: 'Geboortedatum volwassene',
                        },
                        {
                            countInputId: 'aantal_kinderen',
                            wrapperId: 'child-dates-wrapper',
                            containerId: 'child-dates-container',
                            fieldName: 'geboortedata_kinderen[]',
                            fieldId: 'geboortedata_kinderen_',
                            fieldLabelPrefix: 'Geboortedatum kind',
                        },
                        {
                            countInputId: 'aantal_babys',
                            wrapperId: 'baby-dates-wrapper',
                            containerId: 'baby-dates-container',
                            fieldName: 'geboortedata_babys[]',
                            fieldId: 'geboortedata_babys_',
                            fieldLabelPrefix: 'Geboortedatum baby',
                        },
                    ];

                    function renderFields(section, count) {
                        const container = document.getElementById(section.containerId);
                        const wrapper = document.getElementById(section.wrapperId);

                        container.innerHTML = '';

                        if (count <= 0) {
                            wrapper.style.display = 'none';
                            return;
                        }

                        wrapper.style.display = 'block';

                        for (let i = 0; i < count; i++) {
                            const fieldWrapper = document.createElement('div');
                            fieldWrapper.className = 'form-container';

                            const label = document.createElement('label');
                            label.className = 'form-label';
                            label.setAttribute('for', section.fieldId + i);
                            label.textContent = section.fieldLabelPrefix + ' ' + (i + 1) + ' *';

                            const input = document.createElement('input');
                            input.type = 'date';
                            input.name = section.fieldName;
                            input.id = section.fieldId + i;
                            input.required = true;
                            input.className = 'form-input';

                            fieldWrapper.appendChild(label);
                            fieldWrapper.appendChild(input);
                            container.appendChild(fieldWrapper);
                        }
                    }

                    sections.forEach(function(section) {
                        const countInput = document.getElementById(section.countInputId);
                        if (!countInput) {
                            return;
                        }

                        countInput.addEventListener('input', function() {
                            const count = Number(countInput.value) || 0;
                            renderFields(section, count);
                        });
                    });
                })();
            </script>

            <div class="form-container">
                <label for="password" class="form-label">Wachtwoord *</label>
                <input type="password" name="password" id="password" required class="form-input" />
            </div>

            <div class="form-container form-last">
                <label for="password_confirmation" class="form-label">Wachtwoord bevestigen *</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="form-input" />
            </div>

            <button type="submit" class="btn btn-success">Account aanmaken</button>
        </form>

        <div class="center-text margin-top-1">
            <p>Heb je al een account? <a href="/login">Inloggen</a></p>
        </div>
    </div>
</div>
@endsection
