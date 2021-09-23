@extends('layout/main')
@section('title', $title ?? "no title")
@section('content')
<div class="content">
    <h1>Vaccination Management</h1>

{{--     
    <div class="div-1">
        <p>32151 first dose, 4140 second dose</p>
        <div class="div-1-1"><div class="div-1-2"></div></div>
        
    </div>
    <div class="div-2-1">
        <div class="div-2">
            <p>First dose</p>
            <p>32151</p>
        </div>
        <div class="div-2">
            <p>Second dose</p>
            <p>4140</p>
        </div>
    </div> --}}
    <div class="vaccine-information">
        <div class="total-vacc">
            <p>Total vaccinations: {{$vaccinations->total_vaccinations}} <span class="green-colour">+{{$vaccinations->daily_vaccinations}}</span></p>
        </div>
        <div class="people-vacc">
            <div class="vaccinations">
                <p>People vaccinated: {{$vaccinations->people_vaccinated}}</p>
                <p>People fully vaccinated: {{$vaccinations->people_fully_vaccinated}}</p>
                {{-- <p>@php
                    echo round($vaccinations->people_fully_vaccinated / $vaccinations->people_vaccinated, 2);
                @endphp %</p> --}}
                <div class="key">
                    <div class="key-div second-dose"></div><p>second dose </p>
                    <div class="key-div first-dose"></div><p>first dose</p> 
                    <div class="key-div total-pop"></div><p>total population </p>
            </div>
                <div class="total-pop">
                    <div class="first-dose" style="width:
                        @php
                            echo $vaccinations->people_vaccinated_per_hundred
                        @endphp%">
                        <div class="second-dose" style="width:
                        @php
                            echo round($vaccinations->people_fully_vaccinated / $vaccinations->people_vaccinated, 2) *100; 
                        @endphp%">
                        </div>
                    </div>
                </div>
            </div>
            <div class="date-container">
                <div class="date">
                    <p>date:</p>
                    <p>{{$vaccinations->date}}</p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    {{-- total_vaccinations_per_hundred: {{$vaccinations->total_vaccinations_per_hundred}}<br>
    people_vaccinated_per_hundred: {{$vaccinations->people_vaccinated_per_hundred}}<br>
    people_fully_vaccinated_per_hundred: {{$vaccinations->people_fully_vaccinated_per_hundred}}<br>
    daily_vaccinations_per_million: {{$vaccinations->daily_vaccinations_per_million}}<br> --}}
    {{-- @php
        dd($vaccinations);
    @endphp --}}
</div>
@stop
