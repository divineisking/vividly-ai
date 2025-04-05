<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vividly-AI</title>
    
    <!-- Livewire Styles (if using Livewire) -->
    @livewireStyles

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Poppins:wght@400;700&family=Space+Grotesk:wght@400;700&family=IBM+Plex+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;700&family=Source+Code+Pro:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS (via Vite or CDN) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black flex flex-col items-center justify-center min-h-screen">

<body class="bg-black flex flex-col items-center justify-center min-h-screen">

<!-- SECTION: Welcome -->
<section id="welcome-section" class="min-h-screen w-full flex flex-col">
    <!-- Header -->
    <header class="flex items-center justify-start px-6 py-4">
        <h1 class="text-white text-xl font-bold">Vividly</h1>
    </header>

    <!-- Main Card -->
    <main class="flex-grow flex items-center justify-center">
        <!-- Welcome Card -->
        <div id="welcome-card"
            class="w-[90vw] max-w-md h-[80vh] rounded-2xl shadow-lg p-6 flex flex-col justify-between fade-transition">
            <div class="bg-[#060724] p-6 rounded-xl shadow-lg">
                <div>
                    <h1 class="text-3xl font-bold text-[#581EFE]">
                        Welcome<br>
                        To<br>
                        Vividly
                    </h1>
                    <p class="mt-2 text-lg text-[#581EFE] font-mono">Your AI-powered video downloader</p>
                </div>
                <button id="start-btn" class="mt-4 px-6 py-2 bg-white text-[#060724] border-2 border-[#A020F0] rounded">
                    START
                </button>
            </div>
        </div>
    </main>
</section>

<!-- Instructions Section (Initially Hidden) -->
<section id="instructions" class="hidden w-full max-w-md flex flex-col items-center justify-between flex-grow">
    <!-- Header -->
    <div class="flex items-center justify-between w-full px-4 py-2">
        <button id="back-btn" class="text-[#A020F0]">←</button>
        <h1 class="text-[#A020F0] text-lg font-semibold">How it works</h1>
        <a href="/input" class="text-[#A020F0] underline">Skip</a>
    </div>

    <!-- Swipeable Instructions Wrapper -->
    <div id="instructions-wrapper" class="flex transition-transform duration-300 ease-in-out w-full overflow-hidden">
        <!-- Instruction Cards -->
        <div class="w-full flex-shrink-0 px-4">
            <div class="bg-[#0a0a0a] text-white p-4 rounded-lg shadow">
                <h2 class="text-xl font-bold">Step 1</h2>
                <p>Paste your video link on the next page.</p>
            </div>
        </div>
        <div class="w-full flex-shrink-0 px-4">
            <div class="bg-[#0a0a0a] text-white p-4 rounded-lg shadow">
                <h2 class="text-xl font-bold">Step 2</h2>
                <p>Preview the video and review the metadata.</p>
            </div>
        </div>
        <div class="w-full flex-shrink-0 px-4">
            <div class="bg-[#0a0a0a] text-white p-4 rounded-lg shadow flex flex-col items-start">
                <h2 class="text-xl font-bold">Step 3</h2>
                <p>Download your video and copy the metadata.</p>
                <button id="go-btn" class="mt-4 px-6 py-2 bg-white text-[#0a0a0a] border-2 border-[#A020F0] rounded">
                    Go
                </button>
            </div>
        </div>
    </div>

    <!-- Progress Dots -->
    <div id="progress-dots" class="flex justify-center gap-2 py-4">
        <span class="dot w-3 h-3 rounded-full bg-[#A020F0] opacity-50"></span>
        <span class="dot w-3 h-3 rounded-full bg-[#A020F0] opacity-50"></span>
        <span class="dot w-3 h-3 rounded-full bg-[#A020F0] opacity-50"></span>
    </div>
</section>

<!-- Footer -->
<footer class="mt-8 text-white text-sm">
    <p>© 2025 Vividly AI. All rights reserved.</p>
</footer>

@livewireScripts

<!-- Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const startBtn = document.getElementById("start-btn");
        const backBtn = document.getElementById("back-btn");
        const goBtn = document.getElementById("go-btn");
        const welcomeCard = document.getElementById("welcome-card");
        const instructions = document.getElementById("instructions");
        const instructionsWrapper = document.getElementById("instructions-wrapper");
        const dots = document.querySelectorAll(".dot");
        const body = document.body;

        let currentIndex = 0;
        let startX = 0;

        function updateSlide() {
            instructionsWrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
            dots.forEach((dot, index) => {
                dot.classList.toggle("opacity-100", index === currentIndex);
                dot.classList.toggle("opacity-50", index !== currentIndex);
            });
        }

        instructionsWrapper.addEventListener("touchstart", (e) => {
            startX = e.touches[0].clientX;
        });

        instructionsWrapper.addEventListener("touchend", (e) => {
            const endX = e.changedTouches[0].clientX;
            if (startX - endX > 50 && currentIndex < dots.length - 1) currentIndex++;
            else if (endX - startX > 50 && currentIndex > 0) currentIndex--;
            updateSlide();
        });

        startBtn.addEventListener("click", function () {
            welcomeCard.classList.add("fade-out");
            welcomeCard.addEventListener('transitionend', () => {
                welcomeCard.classList.add("hidden");
                instructions.classList.remove("hidden");
                body.classList.remove("bg-black");
                body.classList.add("bg-[#060724]");
                updateSlide();
            }, { once: true });
        });

        backBtn.addEventListener("click", function () {
            instructions.classList.add("fade-out");
            instructions.addEventListener('transitionend', () => {
                instructions.classList.add("hidden");
                welcomeCard.classList.remove("hidden");
                welcomeCard.classList.remove("fade-out");
                instructions.classList.remove("fade-out");
                body.classList.remove("bg-[#060724]");
                body.classList.add("bg-black");
            }, { once: true });
        });
    });
</script>
</body>


</body>
</html>

