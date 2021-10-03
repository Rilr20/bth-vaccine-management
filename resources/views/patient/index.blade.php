@extends('layout/main')
@section('title', $title ?? "no title")
@section('content')

<h1>Patients</h1>
@if (Auth::User() == null)
    <h2>Book a time</h2>
    
@endif
@if (Auth::User() != null)
    <h2>Search</h2>
    <h2>All Patients</h2>
    <div class="patients">
        {{-- <div class="patient">
            <div class="basic-info">
                <p>Rikard Larsson</p>
                <p>9906071234</p>
            </div>
            <p>Gender: Male</p>
            <p>Phone: 07278945612</p>
            <p>DoB: 1999-06-07</p>
            <div class="journal">
                <p>journal about patient 
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam beatae enim placeat dolores odio autem magnam sint numquam eos cupiditate. Autem nesciunt dignissimos odit alias quaerat nostrum minima iste suscipit.
                </p>
            </div>
        </div> --}}

        @foreach ($patients as $patient)
            <div class="patient">
                <div class="basic-info">
                    <p>{{$patient->fullname}}</p>
                    <p>{{$patient->personnumber}}</p>
                </div>
                <p>Gender: {{$patient->gender}}</p>
                <p>Phone: {{$patient->phonenumber}}</p>
                <p>DoB: {{$patient->birthdate}}</p>
                
                <div class="journal">
                    <div class="vaccines">
                        @foreach ($vaccinations as $vaccination) {{--person_vaccine--}}
                            @if ($vaccination->patient_id == $patient->id) 
                                @foreach ($vaccines as $vaccine) {{--vaccine--}}
                                    @if ($vaccination->vaccine_id == $vaccine->id)
                                        <p>{{$vaccine->vaccine_name}} | {{$vaccine->vaccine_type}} </p>
                                        <p class="date-text">Date taken {{substr($vaccination->created_at, 0, 10)}}</p>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                    @if ($patient->journal !== null)
                        <p>{{$patient->journal}}</p>
                        
                    @else
                        <p>Journal is empty</p>
                    @endif
                    
                </div>
            </div>
        @endforeach    
    </div>
    <h2>Upcoming Vaccinations</h2>
@endif

@endsection