<form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- FULL NAME --}}
    <input type="text" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}">
    
    {{-- EMAIL --}}
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
    
    {{-- PASSWORD --}}
    <input type="password" name="password" placeholder="Password">
    
    {{-- CONFIRM PASSWORD --}}
    <input type="password" name="password_confirmation" placeholder="Confirm Password">

    <button type="submit">Register</button>
</form>

{{-- SHOW ERRORS --}}
@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif