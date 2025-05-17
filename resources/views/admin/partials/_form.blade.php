<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="first_name">First Name *</label>
      <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
             id="first_name" name="first_name" 
             value="{{ old('first_name', $patient->first_name ?? '') }}" required>
      @error('first_name')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
  </div>
  
  <div class="col-md-6">
    <div class="form-group">
      <label for="last_name">Last Name *</label>
      <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
             id="last_name" name="last_name" 
             value="{{ old('last_name', $patient->last_name ?? '') }}" required>
      @error('last_name')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="dob">Date of Birth *</label>
      <input type="date" class="form-control @error('dob') is-invalid @enderror" 
             id="dob" name="dob" 
             value="{{ old('dob', isset($patient) ? $patient->dob->format('Y-m-d') : '' }}" required>
      @error('dob')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
  </div>
  
  <div class="col-md-6">
    <div class="form-group">
      <label for="gender">Gender *</label>
      <select class="form-control @error('gender') is-invalid @enderror" 
              id="gender" name="gender" required>
        <option value="">Select Gender</option>
        <option value="male" {{ old('gender', $patient->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ old('gender', $patient->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
        <option value="other" {{ old('gender', $patient->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
      </select>
      @error('gender')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
  </div>
</div>

<div class="form-group">
  <label for="phone">Phone Number *</label>
  <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
         id="phone" name="phone" 
         value="{{ old('phone', $patient->phone ?? '') }}" required>
  @error('phone')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>

<div class="form-group">
  <label for="email">Email Address</label>
  <input type="email" class="form-control @error('email') is-invalid @enderror" 
         id="email" name="email" 
         value="{{ old('email', $patient->email ?? '') }}">
  @error('email')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>

<div class="form-group">
  <label for="address">Address</label>
  <textarea class="form-control @error('address') is-invalid @enderror" 
            id="address" name="address" rows="3">{{ old('address', $patient->address ?? '') }}</textarea>
  @error('address')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="insurance_provider">Insurance Provider</label>
      <input type="text" class="form-control @error('insurance_provider') is-invalid @enderror" 
             id="insurance_provider" name="insurance_provider" 
             value="{{ old('insurance_provider', $patient->insurance_provider ?? '') }}">
      @error('insurance_provider')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
  </div>
  
  <div class="col-md-6">
    <div class="form-group">
      <label for="insurance_number">Insurance Number</label>
      <input type="text" class="form-control @error('insurance_number') is-invalid @enderror" 
             id="insurance_number" name="insurance_number" 
             value="{{ old('insurance_number', $patient->insurance_number ?? '') }}">
      @error('insurance_number')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
  </div>
</div>

<div class="form-group">
  <label for="medical_history">Medical History</label>
  <textarea class="form-control @error('medical_history') is-invalid @enderror" 
            id="medical_history" name="medical_history" rows="3">{{ old('medical_history', $patient->medical_history ?? '') }}</textarea>
  @error('medical_history')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>

<div class="form-group">
  <label for="allergies">Allergies</label>
  <textarea class="form-control @error('allergies') is-invalid @enderror" 
            id="allergies" name="allergies" rows="3">{{ old('allergies', $patient->allergies ?? '') }}</textarea>
  @error('allergies')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>