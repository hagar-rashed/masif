<!-- resources/views/search.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Search Trips</title>
</head>
<body>
    <h1>Search Trips</h1>

    <form action="{{ route('tripSearch') }}" method="GET">
        <label for="from">From:</label>
        <input type="text" name="from" placeholder="Enter take off place"><br>

        <label for="to">To:</label>
        <input type="text" name="to" placeholder="Enter destination"><br>

        <label for="start_date"> Date:</label>
        <input type="date" name="date"><br>

        <button type="submit">Search</button>
    </form>
</body>
</html>
