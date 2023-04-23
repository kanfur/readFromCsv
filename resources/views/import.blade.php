<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Import</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="my-4">CSV Import</h1>
    <div class="my-5">
        <a href="{{ route('dataset.index') }}" class="btn btn-outline-primary">Datasets Table</a>
    </div>
    <form action="{{ route('import.csv') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="csv-file">CSV File:</label>
            <input type="file" class="form-control-file" id="csv-file" name="csv_file" accept=".csv,.txt">
        </div>
        <button type="submit" class="btn btn-primary">File Import</button>
    </form>

    <div class="progress my-4" style="display: none;">
        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
</div>

</body>
</html>
