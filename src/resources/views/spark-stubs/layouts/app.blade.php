<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Testing</title>

    <!-- Scripts -->
    @yield('scripts', '')

</head>
<body>
    <div id="spark-app" v-cloak>        

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>

    </div>

   
</body>
</html>