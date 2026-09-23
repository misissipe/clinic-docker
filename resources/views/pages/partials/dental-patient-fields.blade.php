<div class="form-group mb-1">
  <label class="text-bold-600">I am a <span class="text-danger">*</span></label>
  <select name="role" class="form-control" required>
    <option value="">- Select patient type -</option>
    <option value="Student" {{ old('role') === 'Student' ? 'selected' : '' }}>Student</option>
    <option value="Employee" {{ old('role') === 'Employee' ? 'selected' : '' }}>Employee</option>
  </select>
</div>

<div class="form-group mb-1">
  <label class="text-bold-600">Campus <span class="text-danger">*</span></label>
  <select name="campus" class="form-control" required>
    <option value="">- Select campus -</option>
    <option value="1" {{ old('campus') == '1' ? 'selected' : '' }}>Main Campus</option>
    <option value="2" {{ old('campus') == '2' ? 'selected' : '' }}>Maasin</option>
    <option value="3" {{ old('campus') == '3' ? 'selected' : '' }}>Tomas Oppus</option>
    <option value="4" {{ old('campus') == '4' ? 'selected' : '' }}>Bontoc</option>
    <option value="5" {{ old('campus') == '5' ? 'selected' : '' }}>San Juan</option>
    <option value="6" {{ old('campus') == '6' ? 'selected' : '' }}>Hinunangan</option>
  </select>
</div>

<div class="form-group mb-1">
  <label class="text-bold-600">Student / Employee ID <span class="text-danger">*</span></label>
  <input type="text" name="username" value="{{ old('username') }}"
         class="form-control" placeholder="Enter your ID number" required>
</div>

<div class="form-group mb-1">
  <label class="text-bold-600">Password <span class="text-danger">*</span></label>
  <input type="password" name="password" class="form-control"
         placeholder="Enter your password" required>
</div>

@if (!empty($showConfirmation))
  <div class="form-group mb-2">
    <label class="text-bold-600">Confirm Password <span class="text-danger">*</span></label>
    <input type="password" name="password_confirmation" class="form-control"
           placeholder="Enter your password again" required>
  </div>
@endif

<button type="submit" class="btn btn-primary glow position-relative w-100">
  {{ $buttonText }} <i class="bx bx-right-arrow-alt"></i>
</button>
