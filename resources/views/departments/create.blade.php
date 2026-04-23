@extends('layout')

@section('content')
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h1>Add New Department</h1>
      <a href="{{ route('departments.index') }}" class="btn">Cancel</a>
  </div>
  
  {{-- Standardized Error Block --}}
  @if ($errors->any())
    <div class="alert btn-danger" style="margin-bottom: 20px; border: none; border-radius: 4px;">
      <ul style="margin: 0; padding-left: 20px;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <form action="{{ route('departments.store') }}" method="POST">
      @csrf
      
      <div class="form-group">
        <label for="department_name" style="font-weight: bold;">Department Name</label>
        <input type="text" 
               name="department_name" 
               id="department_name" 
               class="form-control" 
               required 
               maxlength="100" 
               value="{{ old('department_name') }}" 
               placeholder="e.g. Cardiology">
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label for="description" style="font-weight: bold;">Description</label>
        <textarea name="description" 
                  id="description" 
                  class="form-control" 
                  rows="4" 
                  placeholder="Enter a brief description of the department's responsibilities...">{{ old('description') }}</textarea>
      </div>

      <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
        <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Save Department</button>
      </div>
    </form>
  </div>
@endsection