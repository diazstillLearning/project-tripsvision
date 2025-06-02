<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Add Culinary</title>
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
        .container {
            flex: 1;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Add New Culinary</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('Admin.culinaries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Culinary Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="price_range">Price Range</label>
            <select name="price_range" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="low" {{ old('price_range') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('price_range') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('price_range') == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="rating">Rating (0 - 5)</label>
            <input type="number" step="0.1" max="5" min="0" name="rating" class="form-control" value="{{ old('rating') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="cuisine_type">Cuisine Type</label>
            <input type="text" name="cuisine_type" class="form-control" value="{{ old('cuisine_type') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="id_destinations">Destination</label>
            <select name="id_destinations" class="form-control" required>
                <option value="">-- Choose Destination --</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id_destinations }}" {{ old('id_destinations') == $destination->id_destinations ? 'selected' : '' }}>
                        {{ $destination->name }} ({{ $destination->location }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="image_file">Image (optional)</label>
            <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Save Culinary</button>
        <a href="{{ route('Admin.culinaries.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
