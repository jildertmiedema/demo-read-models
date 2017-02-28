@extends('layout')

@section('content')

    <div class="container">

        <div class="starter-template">

            <form method="get" action="?" class="js-filter">
                <button type="submit">Refresh</button>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>account name</td>
                        <td>project name</td>
                        <td>user name</td>
                        <td>appointment date</td>
                        <td>appointment time</td>
                    </tr>
                    <tr class="js-filter-row">
                        <td><input type="text" name="filters[id]" value="{{$query->filter('id')}}"></td>
                        <td><input type="text" name="filters[account_name]" value="{{$query->filter('account_name')}}"></td>
                        <td><input type="text" name="filters[project_name]" value="{{$query->filter('project_name')}}"></td>
                        <td><input type="text" name="filters[user_name]" value="{{$query->filter('user_name')}}"></td>
                        <td><input type="text" name="filters[appointment_date]" value="{{$query->filter('appointment_date')}}"></td>
                        <td><input type="text" name="filters[appointment_time]" value="{{$query->filter('appointment_time')}}"></td>
                    </tr>
                </thead>
                <tbody>
                @foreach($result->items() as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->account_name }}</td>
                        <td>{{ $item->project_name }}</td>
                        <td>{{ $item->user_name }}</td>
                        <td>{{ $item->appointment_date }}</td>
                        <td>{{ $item->appointment_time }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            'use strict';
            let filter = $('.js-filter');
            var timer = null;

            function update() {
                timer = null;

                let url = filter.attr('action');
                url += filter.serialize();
                $.get(url).then(function (result) {
                    let tbody = $(result).find('tbody').html();
                    filter.find('tbody').html(tbody);
                });
            }

            function trigger() {
                if (timer) {
                    clearTimeout(timer);
                }
                timer = setTimeout(function () {
                    update()
                }, 250);
            }

            $('.js-filter-row input', filter).on('change', function () {
                trigger();
            });
            $('.js-filter-row input', filter).on('keyup', function () {
                trigger();
            });
        });
    </script>
@endsection