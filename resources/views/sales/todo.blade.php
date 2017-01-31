@extends('layout')

@section('content')

    <div class="container">

        <div class="starter-template">
            <h1>Todo</h1>
            {!! $items->links() !!}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Account</th>
                        <th>Phone</th>
                        <th>Site</th>
                        <th>Project</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>State</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $result)
                        <tr class="{{ row_class($result) }}">
                            <td>{!! time_class($result) !!}</td>
                            <td>
                                <a href="{{route('account.view', $result->account->id)}}">
                                    {{ $result->account->name }}
                                </a>
                            </td>
                            <td>{{ $result->account->phone }}</td>
                            <td>
                                <a href="{{ $result->account->website }}" target="_blank">
                                    {{ $result->account->website }}
                                </a>
                            </td>
                            <td>{{ $result->project->name }}</td>
                            <td>{{ $result->firstOpenAppointment->date->format('d-m-Y') }}</td>
                            <td>{{ $result->firstOpenAppointment->time }}</td>
                            <td>{{ $result->status->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $items->links() !!}
        </div>

    </div><!-- /.container -->
@endsection