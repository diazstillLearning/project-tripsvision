@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Travel Packages</h2>
    @foreach ($packages as $package)
        <div class="card mt-3 p-3">
            <h4>{{ $package->name }}</h4>
            <p>Total Harga: Rp{{ number_format($package->total_price, 0, ',', '.') }}</p>
            <p>{{ $package->description }}</p>
            <strong>Destinasi:</strong>
            <ul>
                @foreach ($package->destinations as $dest)
                    <li>{{ $dest->name }} - {{ $dest->location }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
@endsection
