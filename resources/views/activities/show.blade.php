@extends('layout')

@section('content')
    <h1>{{$activity->account->name}}</h1>

    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Open appointments</div>
            <table class="table table-bordered">
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->date->format('d-m-Y') }}</td>
                        <td>{{ $appointment->time }}</td>
                        <td>
                            <form method="post" action="{{route('appointment.complete', $appointment->id)}}">
                                {!! csrf_field() !!}
                                <button class="btn btn-default btn-sm"><i class="fa fa-check"></i> </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection