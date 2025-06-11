<!-- resources/views/Admin/destinations/edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Destination</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="{{ route('Admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    <div class="container">
        <a href="#" class="navbar-brand">trips<span style="color:#ffa343;">Vision</span></a>
    </div>
</nav>

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

    <form action="{{ route('Admin.destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $destination->name) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" value="{{ old('location', $destination->location) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Latitude</label>
            <input type="text" name="latitude" value="{{ old('latitude', $destination->latitude) }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Longitude</label>
            <input type="text" name="longitude" value="{{ old('longitude', $destination->longitude) }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Price (Rp)</label>
            <input type="number" name="price" value="{{ old('price', $destination->price) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Rating</label>
            <input type="number" name="rating" value="{{ old('rating', $destination->rating) }}" class="form-control" step="0.1" min="0" max="5" required>
        </div>

        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category" value="{{ old('category', $destination->category) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $destination->description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Current Images</label><br>
            @if ($destination->image_url)
                <img src="{{ asset('storage/' . $destination->image_url) }}" width="100">
            @endif
            @if ($destination->image_url2)
                <img src="{{ asset('storage/' . $destination->image_url2) }}" width="100">
            @endif
            @if ($destination->image_url3)
                <img src="{{ asset('storage/' . $destination->image_url3) }}" width="100">
            @endif
        </div>

        <div class="form-group">
            <label>Change Image 1</label>
            <input type="file" name="image_file" class="form-control-file">
        </div>

        <div class="form-group">
            <label>Change Image 2</label>
            <input type="file" name="image_file2" class="form-control-file">
        </div>

        <div class="form-group">
            <label>Change Image 3</label>
            <input type="file" name="image_file3" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('Admin.destinations.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
