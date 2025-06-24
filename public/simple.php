<?php
// Ultra simple PHP test - bypasses Laravel entirely
echo "<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP Test</title>
    <script src='https://cdn.tailwindcss.com'></script>
</head>
<body class='bg-gray-100 p-8'>
    <div class='max-w-4xl mx-auto bg-white rounded-lg shadow p-6'>
        <h1 class='text-2xl font-bold text-green-600 mb-4'>✅ PHP is Working!</h1>
        <p class='text-gray-600 mb-2'>This bypasses Laravel completely.</p>
        <p class='text-gray-600 mb-2'>PHP Version: " . phpversion() . "</p>
        <p class='text-gray-600 mb-2'>Server Time: " . date('Y-m-d H:i:s') . "</p>
        <p class='text-gray-600 mb-4'>If you see this, the server and PHP are working fine.</p>
        <div class='space-x-4'>
            <a href='/test' class='bg-blue-500 text-white px-4 py-2 rounded'>Laravel Test</a>
            <a href='/debug' class='bg-green-500 text-white px-4 py-2 rounded'>Laravel Debug</a>
            <a href='/' class='bg-red-500 text-white px-4 py-2 rounded'>Laravel Homepage</a>
        </div>
    </div>
</body>
</html>";
?>
