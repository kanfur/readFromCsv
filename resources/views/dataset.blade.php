<!DOCTYPE html>
<html>
<head>
    <title>Dataset</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="my-4">Dataset</h1>
    <div class="my-5">
        <a href="{{ route('import.form') }}" class="btn btn-outline-primary">Upload From File</a>
    </div>
    <form action="{{ route('dataset.index') }}" method="GET" class="form-inline my-3">
        <div class="form-group mx-2">
            <label for="category">Category:</label>
            <select class="form-control mx-2" id="category" name="category">
                <option value="">All</option>
                @foreach($categories as $category)
                    <option value="{{ $category->category }}" {{ $category->category == $selectedCategory ? 'selected' : '' }}>{{ $category->category }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group m-2">
            <label for="gender">Gender:</label>
            <select class="form-control m-2" id="gender" name="gender">
                <option value="">All</option>
                <option value="male" {{ $selectedGender == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $selectedGender == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ $selectedGender == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div class="form-group m-2">
            <label for="birthDate">Birth Date:</label>
            <input type="text" class="form-control mx-2" id="birthDate" name="birthDate" value="{{ $selectedDob }}">
        </div>
        <div class="form-group m-2">
            <label for="age">Age:</label>
            <input type="number" class="form-control mx-2" id="age" name="age" value="{{ $selectedAge }}">
        </div>
        <div class="form-group m-2">
            <label for="ageRange">Age Range:</label>
            <select class="form-control mx-2" id="ageRange" name="ageRange">
                <option value="">All</option>
                @foreach($ageRanges as $ageRange)
                    <option value="{{ $ageRange }}" {{ $ageRange == $selectedAgeRange ? 'selected' : '' }}>{{ $ageRange }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mx-2">Filter</button>
        <a href="{{ route('dataset.index') }}" class="btn btn-secondary">Clear Filters</a>
    </form>


    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Category</th>
            <th>Gender</th>
            <th>Birth Date</th>
            <th>Age</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ $item->category }}</td>
                <td>{{ $item->gender }}</td>
                <td>{{ $item->birthDate }}</td>
                <td>{{ $item->age }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $data->appends(request()->input())->links() }}
</div>
</body>
</html>
