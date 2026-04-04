@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-6">
    <div class="bg-white rounded-3xl shadow-xl p-8">
        <h1 class="text-3xl font-bold mb-6">Visitors</h1>

        <table class="w-full text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>IP</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visitors as $visitor)
                    <tr>
                        <td>{{ $visitor->id }}</td>
                        <td>{{ $visitor->ip }}</td>
                        <td>{{ $visitor->country }}</td>
                        <td>{{ $visitor->city }}</td>
                        <td>{{ $visitor->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection