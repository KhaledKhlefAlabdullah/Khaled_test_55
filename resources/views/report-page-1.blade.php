<!-- resources/views/report-page-1.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A4 Page</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        /*body {*/
        /*    width: 210mm;*/
        /*    height: 297mm;*/
        /*    margin: 0 auto;*/
        /*    border: 2px solid black;*/
        /*    padding: 0;*/
        /*}*/

    </style>
    @vite('resources/css/app.css')

</head>
<body>
{{--    Start Header --}}
<div>
    ROJANA Water Information Report
</div>
{{--    End Header --}}

<h1 class="text-3xl font-bold underline bg-blue-700 p-10 m-10">
    Hello world!
</h1>
<div class="text-3xl">
    Fuck
</div>

</body>
</html>
