<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Antrian BPJS Ketenagakerjaan</title>

    <!-- TAILWINDCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">

        <!-- LOGO -->
        <div class="flex justify-center mb-5">
            <img src="{{ asset('assets/icon-bpjstk.png') }}"
                 alt="BPJS Ketenagakerjaan" class="h-16">
        </div>

        <h2 class="text-2xl font-bold text-center text-green-700 mb-6">
            Login Sistem Antrian
        </h2>

        <!-- ERROR MESSAGE -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- FORM LOGIN -->
        <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
            @csrf

            <!-- USERNAME -->
            <div>
                <label class="font-medium">Username</label>
                <input type="text" name="username" required
                       class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="font-medium">Password</label>
                <input type="password" name="password" required
                       class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <!-- BUTTON LOGIN -->
            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-md transition">
                Login
            </button>
        </form>

        <!-- FOOTER -->
        <p class="text-center text-xs text-gray-500 mt-6">
            © {{ date('Y') }} BPJS Ketenagakerjaan — Sistem Antrian
        </p>

    </div>

</body>

</html>
