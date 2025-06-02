<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Stay</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Add New Stay</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('Admin.stays.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        

        <div class="form-group mb-3">
            <label for="name">Stay Name</label>
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
            <input type="number" name="rating" step="0.1" min="0" max="5" class="form-control" value="{{ old('rating') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>
        <div class="form-group mb-3">
    <label for="amenities">Fasilitas (Amenities)</label><br>
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="amenities[]" value="WiFi" id="wifi">
        <label class="form-check-label" for="wifi">WiFi</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="amenities[]" value="AC" id="ac">
        <label class="form-check-label" for="ac">AC</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="amenities[]" value="Kolam Renang" id="kolam">
        <label class="form-check-label" for="kolam">Kolam Renang</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="amenities[]" value="Parkir Gratis" id="parkir">
        <label class="form-check-label" for="parkir">Parkir Gratis</label>
    </div>
</div>

        <div class="form-group mb-3">
            <label for="id_destinations">Destination</label>
            <select name="id_destinations" class="form-control" required>
                <option value="">-- Select Destination --</option>
                @foreach ($destinations as $destination)
                    <option value="{{ $destination->id_destinations }}" {{ old('id_destinations') == $destination->id_destinations ? 'selected' : '' }}
>
                        {{ $destination->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="image_file">Image (optional)</label>
            <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Save Stay</button>
        <a href="{{ route('Admin.stays.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
