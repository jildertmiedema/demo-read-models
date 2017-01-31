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
                        <tr class="{{ $result->class }}">
                            <td>{!! label_span($result->class) !!}</td>
                            <td><a href="/link">{{ $result->accountName }}</a> </td>
                            <td>{{ $result->accountPhone }}</td>
                            <td>
                                <a href="{{ $result->accountWebsite }}" target="_blank">
                                    {{ $result->accountWebsite }}
                                </a>
                            </td>
                            <td>{{ $result->projectName }}</td>
                            <td>{{ $result->appointmentDate }}</td>
                            <td>{{ $result->appointmentTime }}</td>
                            <td>{{ $result->state }}</td>
                            <td>
                                <a href="{{ route('activity.show', ['id' => $result->activityId]) }}">
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $items->links() !!}
        </div>

    </div><!-- /.container -->
@endsection