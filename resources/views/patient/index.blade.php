@extends('layout/main')
@section('title', $title ?? "no title")
@php
    $book = $book ?? null;
    $patients = $patients ?? null;
    $vaccinations = $vaccinations ?? null;
    $weekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
@endphp
@section('content')

@if (Auth::User() == null)
    
    <div class="vaccine login-form-div">
        <form action="{{url('/patient')}}" method="POST">
            @csrf
            <h2>Book a time</h2>
            <p style="color: #4e4e4e;">{{$book}}</p>
            <div class="input-div">
                <label for="personnumber">Person number</label>
                <input class="input" type="text" name="personnumber" placeholder="XXXXXX1234" maxlength="10" required>
            </div>
            <div class="input-div">
                <label for="name">Full name</label>
                <input class="input" type="text" name="name" placeholder="Full name" >
            </div>
            <div class="input-div">
                <label for="phonenumber"  >Phonenumber</label>

                <input class="input" type="text" name="phonenumber" maxlength="15" placeholder="phonenumber" >
            </div>
            <div class="input-div">
                <label for="birthdate">Birthdate</label>
                <input class="input" type="date" name="birthdate">
            </div>
            <div class="input-div">
                <label for="gender">Gender</label>
                <select class="input select" name="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="input-div">
                @for ($i = 0; $i < count($dates); $i++)
                    
                    @if (in_array($dates[$i], $weekdays))
                        <p>{{$dates[$i]}}</p>
                        @if ( !isset($dates[$i+1]) || in_array($dates[$i+1], $weekdays))
                            <p>No times available</p>
                        @endif
                    @else
                        <div class="radio-div">
                        <input type="radio" name="date" value="{{$dates[$i]}}">
                        <label for="radio">{{$dates[$i]}}</label>
                        </div>
                    @endif
                   
                @endfor
            </div>
            <div class="input-div">
                <label for="vaccine_id">Vaccine</label>
                <select class="input select" name="disease">
                    <option selected="true" disabled="disabled">Select Vaccine</option>
                    {{-- <option>Select Vgsdaccine</option>
                    <option >Selasgdect Vaccine</option>
                    <option>Select Vasdgaccine</option> --}}
                    @php
                        $check= [];
                        foreach ($vaccines as $vaccine) {
                            if (!in_array($vaccine->vaccine_type, $check)) {
                                array_push($check, $vaccine->vaccine_type);
                                echo "<option value=\"$vaccine->vaccine_type\"> $vaccine->vaccine_type</option>";
                            }
                        }
                    @endphp
                    {{-- @foreach ($vaccines as $vaccine)
                        
                    @endforeach --}}
                </select>
            </div>
            @if (!array_diff($dates, $weekdays))
                <p>No times available check again tomorrow :)</p>
            @else 
                <div class="input-div">
                    <input class="form-button login-button" type="submit" value="Done">
                </div>
            @endif
            
            <input type="hidden" name="book" value="book">
        </form>
    </div>
@endif
@if (Auth::User() != null)

    {{-- <h2>Search</h2> --}}
    <form class="center search" action="{{url('/patient')}}" method="GET">
    @csrf
        <input class="input" type="text" placeholder="search..." name="search">
        <input class="button" type="submit" value="search">
    </form>
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
                                        <p class="date-text">Date taken {{$vaccination->created_at, 0, 10}} </p>
                                        <p class="date-text">Expiration date: {{$vaccination->expiration_date}}</p>
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
@endif

@endsection