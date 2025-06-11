<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" />

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .logo {
            font-size: 33px;
            color: #fff;
            font-weight: 700;
        }
        span {
            color: #ffa343;
        }
        .navbar {
            display: flex;
        }
        .container {
            flex: 1;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            border-top: 1px solid #ddd;
        }
        .recent-activities {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="" class="logo">trips<span>Vision</span></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link" style="display: inline; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
                </li>
                </ul>
            </div>
        </div>
    </nav>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Admin Dashboard</h1>
    
    <!-- Statistik -->
    <div class="row text-center">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h4 class="card-title">Destinations</h4>
                    <p class="card-text">{{ $totalDestinations }} Total</p>
                    <a href="{{ route('Admin.destinations.index') }}" class="btn btn-light btn-sm">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h4 class="card-title">Culinaries</h4>
                    <p class="card-text">{{ $totalCulinaries }} Total</p>
                    <a href="{{ route('Admin.culinaries.index') }}" class="btn btn-light btn-sm">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h4 class="card-title">Stays</h4>
                    <p class="card-text">{{ $totalStays }} Total</p>
                    <a href="{{ route('Admin.stays.index') }}" class="btn btn-light btn-sm">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h4 class="card-title">Users</h4>
                    <p class="card-text">{{ $totalUsers }} Total</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        {{-- Recent Destinations --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Recent Destinations</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($newDestinations as $destination)
                            <li class="list-group-item">{{ $destination->name }} (ID: {{ $destination->id_destinations }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- Recent Culinaries --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">Recent Culinaries</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($newCulinaries as $culinary)
                            <li class="list-group-item">{{ $culinary->name }} (ID: {{ $culinary->id_culinaries }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- Recent Stays --}}
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header bg-warning text-white">Recent Stays</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($newStays as $stay)
                            <li class="list-group-item">{{ $stay->name }} (ID: {{ $stay->id_stays }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- Recent Users --}}
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header bg-danger text-white">Recent Users</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($newUsers as $user)
                            <li class="list-group-item">{{ $user->username }} (ID: {{ $user->id }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

