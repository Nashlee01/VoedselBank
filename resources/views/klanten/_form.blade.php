<style>
    .klant-form-wrapper {
        max-width: 900px;
        margin: 30px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .klant-form-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #1f2937;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group-full {
        grid-column: 1 / -1;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #374151;
    }

    .form-control {
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 15px;
        transition: 0.2s ease-in-out;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .error-text {
        color: #dc2626;
        font-size: 14px;
        margin-top: 6px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        margin: 25px 0 10px;
        color: #111827;
    }

    .date-block {
        margin-top: 10px;
        padding: 15px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }

    .date-item {
        margin-bottom: 12px;
    }

    .btn-row {
        display: flex;
        gap: 12px;
        margin-top: 25px;
    }

    .btn {
        display: inline-block;
        padding: 12px 18px;
        border-radius: 10px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 15px;
        font-weight: 600;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@php
    $volwassenen = old('aantal_volwassenen', $klant->aantal_volwassenen ?? 1);
    $kinderen = old('aantal_kinderen', $klant->aantal_kinderen ?? 0);
    $babys = old('aantal_babys', $klant->aantal_babys ?? 0);

    $oudeVolwassenData = old('geboortedata_volwassenen', $klant->geboortedata_volwassenen ?? []);
    $oudeKinderenData = old('geboortedata_kinderen', $klant->geboortedata_kinderen ?? []);
    $oudeBabysData = old('geboortedata_babys', $klant->geboortedata_babys ?? []);
@endphp

<div class="klant-form-wrapper">
    <div class="klant-form-title">
        {{ isset($klant) ? 'Klant wijzigen' : 'Nieuwe klant toevoegen' }}
    </div>

    <div class="form-grid">
        <div class="form-group">
            <label for="gezinsnaam" class="form-label">Gezinsnaam *</label>
            <input type="text" name="gezinsnaam" id="gezinsnaam" class="form-control"
                   value="{{ old('gezinsnaam', $klant->gezinsnaam ?? '') }}" required>
            @error('gezinsnaam') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="straat" class="form-label">Straat *</label>
            <input type="text" name="straat" id="straat" class="form-control"
                   value="{{ old('straat', $klant->straat ?? '') }}" required>
            @error('straat') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="huisnummer" class="form-label">Huisnummer *</label>
            <input type="text" name="huisnummer" id="huisnummer" class="form-control"
                   value="{{ old('huisnummer', $klant->huisnummer ?? '') }}" required>
            @error('huisnummer') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="toevoeging" class="form-label">Toevoeging</label>
            <input type="text" name="toevoeging" id="toevoeging" class="form-control"
                   value="{{ old('toevoeging', $klant->toevoeging ?? '') }}">
            @error('toevoeging') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="postcode" class="form-label">Postcode *</label>
            <input type="text" name="postcode" id="postcode" class="form-control"
                   value="{{ old('postcode', $klant->postcode ?? '') }}" required>
            @error('postcode') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="plaats" class="form-label">Plaats *</label>
            <input type="text" name="plaats" id="plaats" class="form-control"
                   value="{{ old('plaats', $klant->plaats ?? '') }}" required>
            @error('plaats') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="telefoonnummer" class="form-label">Telefoonnummer *</label>
            <input type="text" name="telefoonnummer" id="telefoonnummer" class="form-control"
                   value="{{ old('telefoonnummer', $klant->telefoonnummer ?? '') }}" required>
            @error('telefoonnummer') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email *</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{ old('email', $klant->email ?? '') }}" required>
            @error('email') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="aantal_volwassenen" class="form-label">Aantal volwassenen *</label>
            <input type="number" name="aantal_volwassenen" id="aantal_volwassenen" class="form-control"
                   value="{{ $volwassenen }}" min="0" required>
            @error('aantal_volwassenen') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="aantal_kinderen" class="form-label">Aantal kinderen *</label>
            <input type="number" name="aantal_kinderen" id="aantal_kinderen" class="form-control"
                   value="{{ $kinderen }}" min="0" required>
            @error('aantal_kinderen') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-group form-group-full">
            <label for="aantal_babys" class="form-label">Aantal baby's *</label>
            <input type="number" name="aantal_babys" id="aantal_babys" class="form-control"
                   value="{{ $babys }}" min="0" required>
            @error('aantal_babys') <div class="error-text">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="section-title">Geboortedata van volwassenen</div>
    @error('geboortedata_volwassenen') <div class="error-text">{{ $message }}</div> @enderror
    <div id="volwassenen-dates" class="date-block"></div>

    <div class="section-title">Geboortedata van kinderen</div>
    @error('geboortedata_kinderen') <div class="error-text">{{ $message }}</div> @enderror
    <div id="kinderen-dates" class="date-block"></div>

    <div class="section-title">Geboortedata van baby's</div>
    @error('geboortedata_babys') <div class="error-text">{{ $message }}</div> @enderror
    <div id="babys-dates" class="date-block"></div>

    <div class="btn-row">
        <button type="submit" class="btn btn-primary">Opslaan</button>
        <a href="{{ route('klanten.index') }}" class="btn btn-secondary">Terug</a>
    </div>
</div>

<script>
    /*
    |--------------------------------------------------------------------------
    | Dynamische geboortedatum velden
    |--------------------------------------------------------------------------
    | Op basis van het aantal volwassenen, kinderen en baby's maken we automatisch
    | de juiste datumvelden aan in het formulier.
    */
    const oudeVolwassenData = @json($oudeVolwassenData);
    const oudeKinderenData = @json($oudeKinderenData);
    const oudeBabysData = @json($oudeBabysData);

    function maakDatumVelden(aantalInputId, containerId, naam, labelPrefix, oudeData = []) {
        const aantal = parseInt(document.getElementById(aantalInputId).value) || 0;
        const container = document.getElementById(containerId);

        container.innerHTML = '';

        for (let i = 0; i < aantal; i++) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('date-item');

            const label = document.createElement('label');
            label.classList.add('form-label');
            label.textContent = `${labelPrefix} ${i + 1} *`;

            const input = document.createElement('input');
            input.type = 'date';
            input.name = `${naam}[]`;
            input.classList.add('form-control');
            input.required = true;

            if (oudeData[i]) {
                input.value = oudeData[i];
            }

            wrapper.appendChild(label);
            wrapper.appendChild(input);
            container.appendChild(wrapper);
        }
    }

    function renderAlleDatumVelden() {
        maakDatumVelden('aantal_volwassenen', 'volwassenen-dates', 'geboortedata_volwassenen', 'Geboortedatum volwassene', oudeVolwassenData);
        maakDatumVelden('aantal_kinderen', 'kinderen-dates', 'geboortedata_kinderen', 'Geboortedatum kind', oudeKinderenData);
        maakDatumVelden('aantal_babys', 'babys-dates', 'geboortedata_babys', 'Geboortedatum baby', oudeBabysData);
    }

    document.getElementById('aantal_volwassenen').addEventListener('input', renderAlleDatumVelden);
    document.getElementById('aantal_kinderen').addEventListener('input', renderAlleDatumVelden);
    document.getElementById('aantal_babys').addEventListener('input', renderAlleDatumVelden);

    renderAlleDatumVelden();
</script>