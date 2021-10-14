@extends('layout/staff')
@section('title', $title ?? "no title")
@section('content')
<div class="staff-content">
    <h1>{{Auth::user()->fullname}}</h1>

    <p>Created at: {{Auth::user()->created_at}}</p>
    <div class="staff-history">
        <h3>History</h3>
        <table>
            <tr>
                <th>Patient</th>
                <th>Vaccine</th>
                <th>Date</th>
            </tr>
        @foreach ($history as $row)
            <tr class="align">
                <td>{{$row->patient_id}}</td>
                <td>{{$row->vaccine_id}}</td>
                <td>{{$row->created_at}}</td>
            </tr>
        @endforeach
        </table>
    </div>
    <h2>Upcoming</h2>
    <div class="staff-history">
    @foreach ($schedule as $row)
        <form action="{{url("/vaccine")}}" method="POST">
            @csrf
            <div class="history">
                <p>
                    patient: {{$row->personnumber}} vaccine: {{$row->disease}} {{$row->booked}}
                </p>
                <select style="" class="select-staff" name="vaccine_id">
                        <option selected="true" disabled="disabled">Select Vaccine</option>
                        {{-- <option>Select Vgsdaccine</option>
                        <option >Selasgdect Vaccine</option>
                        <option>Select Vasdgaccine</option> --}}
                        @foreach ($vaccines as $vaccine)
                            @if ($vaccine->vaccine_type == $row->disease)
                                <option value="{{$vaccine->id}}">{{$vaccine->vaccine_name }} | {{ $vaccine->vaccine_type}}</option>
                                
                            @endif
                        @endforeach
                    </select>
                    <input type="hidden" name="staff" value="staff">
                    <input type="hidden" name="staff" value="{{Auth::user()->id}}">
                    <input type="hidden" name="schedule" value="{{$row->id}}">
                    <input type="hidden" name="personnumber" value="{{$row->personnumber}}">
                    <input class="form-button" type="submit" value="Done">
            </div>
        </form>
    @endforeach
    </div>
</div>
@stop