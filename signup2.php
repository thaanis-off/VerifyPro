<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <button class="bg-blue-500 text-white px-4 py-2" onclick="showDialog()">Open Modal</button>

    <div id="dialog" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75  justify-center items-center opacity-0 transition-opacity duration-300">
        <div class="bg-white p-4 rounded">
            <p>Modal Content</p>
            <button class="mt-4 bg-red-500 text-white px-4 py-2" onclick="hideDialog()">Close</button>
        </div>
    </div>


</body>

</html>