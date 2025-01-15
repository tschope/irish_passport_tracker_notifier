@include('emails.header')
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
<div class="bg-white p-6 rounded-lg shadow-lg text-center max-w-md w-full">
    <h1 class="text-2xl font-semibold text-green-600 mb-4">{{ $message }}</h1>
    <p class="text-gray-700 mb-4">You will be redirected shortly...</p>
    <div class="text-sm text-gray-500">Please wait...</div>
</div>
</body>
</html>
