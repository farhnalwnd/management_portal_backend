<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Failed | Oneject Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        .glow {
            box-shadow: 0 20px 40px -15px rgba(239, 68, 68, 0.08);
        }
        .progress-bar {
            transition: width 1s linear;
        }
    </style>
</head>
<body class="bg-cyan-50/50 text-cyan-950 flex items-center justify-center min-h-screen p-6 relative overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute top-[-20%] left-[-20%] w-[60%] h-[60%] bg-[#f43f5e] rounded-full blur-[120px] opacity-10 pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-20%] w-[60%] h-[60%] bg-[#0891b2] rounded-full blur-[120px] opacity-15 pointer-events-none"></div>

    <div class="max-w-md w-full bg-white/80 backdrop-blur-xl border border-cyan-100 shadow-2xl rounded-3xl overflow-hidden glow relative z-10">
        <div class="p-10 text-center">
            <!-- Glowing Error Icon -->
            <div class="w-24 h-24 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-8 border border-rose-100 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h1 class="text-3xl font-extrabold mb-3 tracking-tight bg-gradient-to-r from-rose-500 to-orange-500 bg-clip-text text-transparent">Gagal Diproses!</h1>
            <p class="text-cyan-900/70 mb-4 text-sm leading-relaxed">
                Tindakan tidak dapat dilanjutkan. Link persetujuan ini sudah tidak valid, kadaluarsa, atau telah diproses sebelumnya.
            </p>
            @if(isset($e))
                <p class="text-xs font-mono text-rose-600 bg-rose-50 border border-rose-100 rounded-xl p-3 mb-8 text-left break-words">
                    <strong>Pesan Error:</strong> {{ $e->getMessage() }}
                </p>
            @endif

            <!-- Progress Meter -->
            <div class="bg-cyan-50/40 border border-cyan-100/80 rounded-2xl p-5 mb-4">
                <div class="overflow-hidden h-2 mb-3 rounded-full bg-cyan-100">
                    <div id="progress" class="progress-bar h-full bg-gradient-to-r from-rose-500 to-orange-400" style="width: 100%"></div>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-cyan-800/60 font-medium">Auto-close Jendela</span>
                    <span class="text-rose-500 font-mono font-bold" id="timer">Menutup dalam 5s...</span>
                </div>
            </div>

            <!-- Manual Close fallback -->
            <div id="manual-close" class="hidden mt-6 pt-6 border-t border-cyan-100">
                <button onclick="window.close()" class="w-full py-3 px-4 bg-rose-500 hover:bg-rose-600 active:bg-rose-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg shadow-rose-500/10 hover:shadow-rose-500/20">
                    Tutup Jendela Sekarang
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
                window.close();
                setTimeout(() => {
                    manualSection.classList.remove('hidden');
                }, 1000);
            }
        }, 1000);
    </script>
</body>
</html>
