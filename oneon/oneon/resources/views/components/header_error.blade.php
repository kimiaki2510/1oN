@if (count($errors) > 0)
  <div class="error-container">
    <div class="error-group">
      <ul>
        @foreach ($errors->all() as $error)
          <li class="error-message">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif