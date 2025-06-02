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
         <a href="{{ route('Admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        <div class="container">
            <a href="" class="logo">trips<span>Vision</span></a>

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
    <h1>Edit Destination</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('Admin.destinations.update', $destination->id_destinations) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input
                type="text"
                name="name"
                class="form-control"
                id="name"
                value="{{ old('name', $destination->name) }}"
                required
            />
        </div>

        <div class="form-group mb-3">
            <label for="location">Location</label>
            <input
                type="text"
                name="location"
                class="form-control"
                id="location"
                value="{{ old('location', $destination->location) }}"
                required
            />
        </div>

        <div class="form-group mb-3">
            <label for="price_range">Price Range</label>
            <select name="price_range" id="price_range" class="form-control" required>
                <option value="">-- Select Price Range --</option>
                <option value="low" {{ old('price_range', $destination->price_range) == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('price_range', $destination->price_range) == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('price_range', $destination->price_range) == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="rating">Rating (0 - 5)</label>
            <input
                type="number"
                name="rating"
                class="form-control"
                id="rating"
                min="0"
                max="5"
                step="0.1"
                value="{{ old('rating', $destination->rating) }}"
                required
            />
        </div>

        <div class="form-group mb-3">
            <label for="category">Category</label>
            <input
                type="text"
                name="category"
                class="form-control"
                id="category"
                value="{{ old('category', $destination->category) }}"
            />
        </div>

        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea
                name="description"
                id="description"
                rows="4"
                class="form-control"
                required
            >{{ old('description', $destination->description) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="image">Current Image</label><br />
            @if ($destination->image)
                <img
                    src="{{ asset('storage/' . $destination->image) }}"
                    alt="Destination Image"
                    style="max-width: 200px;"
                />
            @else
                <p>No image uploaded.</p>
            @endif
        </div>

        <div class="form-group mb-3">
            <label for="image">Change Image (optional)</label>
            <input
                type="file"
                name="image"
                id="image"
                class="form-control"
                accept="image/*"
            />
        </div>

        <button type="submit" class="btn btn-primary">Update Destination</button>
        <a href="{{ route('Admin.destinations.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
