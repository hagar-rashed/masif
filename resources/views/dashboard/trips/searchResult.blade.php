<!-- resources/views/trips/search_results.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results</h1>
    @if($trips->isEmpty())
        <p>No trips found.</p>
    @else
        @foreach($trips as $trip)
            <div>
                <h3>{{ $trip->name }}</h3>
                <p>From: {{ $trip->from }}</p>
                <p>To: {{ $trip->to }}</p>
                <p>Start Date: {{ $trip->start_date }}</p>
                <p>End Date: {{ $trip->end_date }}</p>
            </div>
        @endforeach
    @endif
</body>
</html>
