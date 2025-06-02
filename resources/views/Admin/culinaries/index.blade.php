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
            <a href="{{ route('Admin.dashboard') }}" class="logo">trips<span>Vision</span></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href=""><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</head>
<body>
<div class="container mt-5">
    <h1>Manage Culinaries</h1>
    <a href="{{ route('Admin.culinaries.create') }}" class="btn btn-primary mb-3">Add Culinary</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Price Range</th>
                <th>Rating</th>
                <th>Cuisine Type</th>
                <th>Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($culinaries as $culinary)
            <tr>
                <td>{{ $culinary->id_culinaries }}</td>
                <td>{{ $culinary->name }}</td>
                <td>{{ $culinary->location }}</td>
                <td>{{ ucfirst($culinary->price_range) }}</td>
                <td>{{ $culinary->rating }}</td>
                <td>{{ $culinary->cuisine_type }}</td>
                <td>{{ $culinary->description }}</td>
                <td>
                    @if($culinary->image_url)
                        <img src="{{ asset('storage/' . $culinary->image_url) }}" alt="Culinary Image" style="max-width: 100px;">
                    @else
                        No Image
                    @endif
                </td>
                <td>
                    <a href="{{ route('Admin.culinaries.edit', $culinary->id_culinaries) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('Admin.culinaries.destroy', $culinary->id_culinaries) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
