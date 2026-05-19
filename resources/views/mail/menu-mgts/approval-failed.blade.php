<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Failed | Oneject Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #F8F9FA;
            color: #4D4D4D;
        }

        .border-secondary {
            border-color: #68B2D8;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white shadow-xl rounded-2xl overflow-hidden border-t-8 border-secondary">
        <div class="p-8 text-center">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <h1 class="text-2xl font-bold mb-2 text-gray-700">Gagal Diproses</h1>
            <p class="text-gray-500 mb-6 text-sm">
                Token tidak valid atau sudah kadaluarsa. Jendela ini akan segera ditutup.
            </p>

            <div class="text-xs text-gray-400 font-mono" id="timer">Menutup dalam 5s...</div>

            <div id="manual-close" class="hidden mt-6">
                <button onclick="window.close()" class="text-sm font-bold text-[#68B2D8] hover:underline">
                    Tutup Jendela Manual
                </button>
            </div>
        </div>
    </div>

    <script>
        let timeLeft = 5;
        const countdown = setInterval(() => {
            timeLeft--;
            document.getElementById('timer').innerText = `Menutup dalam ${timeLeft}s...`;
            if (timeLeft <= 0) {
                clearInterval(countdown);
                window.close();
                setTimeout(() => {
                    document.getElementById('manual-close').classList.remove('hidden');
                }, 500);
            }
        }, 1000);
    </script>
</body>

</html>
