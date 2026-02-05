<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success | Oneject Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #F8F9FA;
            color: #4D4D4D;
        }

        .text-primary {
            color: #2C6975;
        }

        .bg-primary {
            background-color: #2C6975;
        }

        .progress-bar {
            transition: width 1s linear;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white shadow-2xl rounded-2xl overflow-hidden border-t-8 border-[#2C6975]">
        <div class="p-8 text-center">
            <div
                class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-2xl font-bold mb-2 text-primary">Persetujuan Berhasil!</h1>
            <p class="text-gray-500 mb-8 text-sm">
                Tindakan Anda telah tercatat. Jendela ini akan ditutup secara otomatis.
            </p>

            <div class="relative pt-1">
                <div class="overflow-hidden h-1.5 mb-4 rounded bg-gray-100">
                    <div id="progress" class="progress-bar h-full bg-primary" style="width: 100%"></div>
                </div>
                <div class="text-xs text-gray-400 font-mono" id="timer">Menutup dalam 5s...</div>
            </div>

            <div id="manual-close" class="hidden mt-6 pt-6 border-t border-gray-100">
                <p class="text-xs text-red-400 mb-2">Auto-close diblokir oleh browser.</p>
                <button onclick="window.close()" class="text-sm font-bold text-primary hover:underline">
                    Klik di sini untuk menutup jendela
                </button>
            </div>
        </div>
    </div>

    <script>
        let timeLeft = 5;
        const timerText = document.getElementById('timer');
        const progressBar = document.getElementById('progress');
        const manualSection = document.getElementById('manual-close');

        const countdown = setInterval(() => {
            timeLeft--;
            timerText.innerText = `Menutup dalam ${timeLeft}s...`;
            progressBar.style.width = (timeLeft / 5 * 100) + "%";

            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerText.innerText = "Selesai.";

                // Eksekusi penutupan jendela
                window.close();

                // Jika setelah 1 detik jendela masih terbuka, munculkan tombol manual
                setTimeout(() => {
                    manualSection.classList.remove('hidden');
                }, 1000);
            }
        }, 1000);
    </script>
</body>

</html>
