<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Destination</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Add New Destination</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('Admin.destinations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Destination Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="price">Price (number)</label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="rating">Rating (0 - 5)</label>
            <input type="number" name="rating" step="0.1" min="0" max="5" class="form-control" value="{{ old('rating') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="category">Category</label>
            <input type="text" name="category" class="form-control" value="{{ old('category') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
        </div>

        <!-- Tambahan: Longitude dan Latitude -->
        <div class="form-group mb-3">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" class="form-control" value="{{ old('longitude') }}" placeholder="e.g., 107.6191">
        </div>

        <div class="form-group mb-3">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" class="form-control" value="{{ old('latitude') }}" placeholder="e.g., -6.9175">
        </div>

        <div class="form-group mb-3">
            <label for="image_file">Image 1 (optional)</label>
            <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>
        <div class="form-group mb-3">
            <label for="image_file2">Image 2 (optional)</label>
            <input type="file" name="image_file2" class="form-control" accept="image/*">
        </div>
        <div class="form-group mb-3">
            <label for="image_file3">Image 3 (optional)</label>
            <input type="file" name="image_file3" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Save Destination</button>
        <a href="{{ route('Admin.destinations.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
