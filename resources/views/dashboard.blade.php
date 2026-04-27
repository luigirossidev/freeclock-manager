<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreeClock - Home</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap');

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* === BACKGROUND SLIDESHOW === */
        .bg-slideshow {
            position: fixed;
            inset: 0;
            z-index: 0;
        }

        .bg-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 2s ease-in-out;
        }

        .bg-slide.active {
            opacity: 1;
        }

        .bg-slide:nth-child(1) {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        }
        .bg-slide:nth-child(2) {
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
        }
        .bg-slide:nth-child(3) {
            background: linear-gradient(135deg, #2c003e, #512b58, #2c003e);
        }
        .bg-slide:nth-child(4) {
            background: linear-gradient(135deg, #0d1b2a, #1b263b, #415a77);
        }
        .bg-slide:nth-child(5) {
            background: linear-gradient(135deg, #1a0a2e, #2d1b69, #11001c);
        }

        /* === OVERLAY === */
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        /* === MAIN CONTENT === */
        body {
            font-family: 'Inter', sans-serif;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .dashboard {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 720px;
            text-align: center;
        }

        /* === LOGO === */
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.5);
        }

        .logo .accent {
            color: #f0c040;
        }

        /* === flip CLOCK === */
        .flip-clock {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 3rem;
        }

        /* Flip digit panels */
        .flip-clock__time {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .flip-digit {
            position: relative;
            width: 72px;
            height: 100px;
            background: linear-gradient(to bottom, #2a2a2a 0%, #1a1a1a 45%, #111 55%, #1a1a1a 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 5rem;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.08);
            overflow: hidden;
            padding-bottom: 26px;
        }

        .flip-digit::before {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            height: 2px;
            background: rgba(0, 0, 0, 0.6);
            z-index: 2;
            box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05);
        }

        .flip-digit::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 50%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.06), transparent);
            border-radius: 8px 8px 0 0;
            z-index: 1;
            pointer-events: none;
        }

        .flip-colon {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-weight: 700;
            color: #fff;
            padding: 0 4px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            line-height: 1;
            margin-top: -8px;
        }

        /* Side info panels */
        .flip-clock__date,
        .flip-clock__day {
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 300;
            letter-spacing: 0.06em;
            text-transform: capitalize;
            opacity: 0.9;
            text-shadow: 0 1px 8px rgba(0, 0, 0, 0.4);
            padding: 0 1.2rem;
            line-height: 1.6;
            max-width: 8rem;
            text-align: center;
            color: #e0e0e0;
        }

        .flip-clock__separator {
            width: 1px;
            height: 4rem;
            background: linear-gradient(to bottom, transparent, rgba(240, 192, 64, 0.6), transparent);
            flex-shrink: 0;
        }

        /* === CARDS === */
        .card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 1rem;
            padding: 2rem 2.25rem;
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .card-label {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #f0c040;
            margin-bottom: 0.75rem;
        }

        .card-text {
            font-size: 1.1rem;
            line-height: 1.7;
            font-weight: 300;
        }

        .card-text em {
            font-style: italic;
            opacity: 0.8;
        }

        /* === ANSWER SECTION === */
        .answer {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .answer-label {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #7ec8e3;
            margin-bottom: 0.4rem;
        }

        .answer-text {
            font-size: 1rem;
            font-weight: 400;
        }

        .answer-reveal {
            cursor: pointer;
        }

        .answer-reveal .answer-content {
            display: none;
        }

        .answer-reveal .answer-placeholder {
            font-size: 0.85rem;
            font-style: italic;
            opacity: 0.5;
            text-align: center;
            padding: 0.3rem 0;
        }

        .answer-reveal.revealed .answer-content {
            display: block;
        }

        .answer-reveal.revealed .answer-placeholder {
            display: none;
        }

        .answer-hidden {
            font-size: 0.85rem;
            font-style: italic;
            opacity: 0.5;
        }

        /* === INDICATOR DOTS === */
        .dots {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            transition: background 0.5s;
        }

        .dot.active {
            background: rgba(240, 192, 64, 0.8);
        }

        /* === NO DATA === */
        .no-data {
            opacity: 0.5;
            font-style: italic;
        }

        /* === FOOTER === */
        .footer {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2.5rem;
        }

        .footer-btn {
            display: inline-block;
            padding: 0.6rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: #fff;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 2rem;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            transition: background 0.3s, border-color 0.3s;
        }

        .footer-btn:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .footer-btn.accent {
            background: rgba(240, 192, 64, 0.15);
            border-color: rgba(240, 192, 64, 0.4);
            color: #f0c040;
        }

        .footer-btn.accent:hover {
            background: rgba(240, 192, 64, 0.3);
            border-color: rgba(240, 192, 64, 0.6);
        }

        /* === RESPONSIVE === */
        @media (max-width: 600px) {
            .logo {
                font-size: 2.5rem;
            }
            .flip-digit {
                width: 48px;
                height: 68px;
                font-size: 3.2rem;
                border-radius: 6px;
            }
            .flip-colon {
                font-size: 2.8rem;
                padding: 0 2px;
            }
            .flip-clock__date,
            .flip-clock__day {
                font-size: 0.75rem;
                padding: 0 0.6rem;
                max-width: 5rem;
            }
            .flip-clock__separator {
                height: 2.5rem;
            }
            .flip-clock {
                margin-bottom: 2rem;
            }
            .card {
                padding: 1.5rem;
            }
            .card-text {
                font-size: 1rem;
            }
            .footer {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

    <!-- Background Slideshow -->
    <div class="bg-slideshow">
        <div class="bg-slide active"></div>
        <div class="bg-slide"></div>
        <div class="bg-slide"></div>
        <div class="bg-slide"></div>
        <div class="bg-slide"></div>
    </div>
    <div class="overlay"></div>

    <!-- Dashboard Content -->
    <div class="dashboard">

        <!-- Logo
        <h1 class="logo">Free<span class="accent">Clock</span></h1>
        -->

        <!-- flip Clock -->
        <div class="flip-clock">
            <div class="flip-clock__date" id="flip-date"></div>
            <div class="flip-clock__separator"></div>
            <div class="flip-clock__time" id="flip-time">
                <div class="flip-digit" id="h1">0</div>
                <div class="flip-digit" id="h2">0</div>
                <div class="flip-colon">:</div>
                <div class="flip-digit" id="m1">0</div>
                <div class="flip-digit" id="m2">0</div>
            </div>
            <div class="flip-clock__separator"></div>
            <div class="flip-clock__day" id="flip-day"></div>
        </div>

        <!-- Quote of the Day -->
        <div class="card">
            <div class="card-label">{{ __('dashboard.quote_of_the_day') }}</div>
            @if($quote)
                <div class="card-text">{{ $quote->quote }}</div>
            @else
                <div class="card-text no-data">{{ __('dashboard.no_quote') }}</div>
            @endif
        </div>

        <!-- Riddle of the Day -->
        <div class="card">
            <div class="card-label">{{ __('dashboard.riddle_of_the_day') }}</div>
            @if($riddle)
                <div class="card-text">{{ $riddle->riddle }}</div>
                <div class="answer">
                    @if($showAnswer)
                        <div class="answer-reveal" id="answer-toggle" onclick="this.classList.add('revealed')">
                            <div class="answer-placeholder">{{ __('dashboard.tap_to_reveal') }}</div>
                            <div class="answer-content">
                                <div class="answer-label">{{ __('dashboard.solution') }}</div>
                                <div class="answer-text">{{ $riddle->answer }}</div>
                            </div>
                        </div>
                    @else
                        <div class="answer-hidden">{{ __('dashboard.answer_after_18') }}</div>
                    @endif
                </div>
            @else
                <div class="card-text no-data">{{ __('dashboard.no_riddle') }}</div>
            @endif
        </div>

        <!-- Slideshow Dots -->
        <div class="dots">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <a href="{{ config('freeclock.project_url') }}" class="footer-btn" target="_blank" rel="noopener noreferrer">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: -2px; margin-right: 4px;">
                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                </svg>
                {{ __('dashboard.about') }}
            </a>
            <a href="/admin/login" class="footer-btn accent">{{ __('dashboard.login') }}</a>
        </div>
    </div>

    <script>
        (function () {
            // flip Clock
            const h1 = document.getElementById('h1');
            const h2 = document.getElementById('h2');
            const m1 = document.getElementById('m1');
            const m2 = document.getElementById('m2');
            const flipDate = document.getElementById('flip-date');
            const flipDay = document.getElementById('flip-day');

            function updateClock() {
                const now = new Date();
                const h = String(now.getHours()).padStart(2, '0');
                const m = String(now.getMinutes()).padStart(2, '0');
                h1.textContent = h[0];
                h2.textContent = h[1];
                m1.textContent = m[0];
                m2.textContent = m[1];

                const dayNum = now.getDate();
                const locale = '{{ app()->getLocale() }}';
                const month = now.toLocaleDateString(locale, { month: 'long' });
                const year = now.getFullYear();
                flipDate.textContent = dayNum + ' ' + month + ' ' + year;

                flipDay.textContent = now.toLocaleDateString(locale, { weekday: 'long' });
            }
            updateClock();
            setInterval(updateClock, 1000);

            // Background slideshow
            const slides = document.querySelectorAll('.bg-slide');
            const dots = document.querySelectorAll('.dot');
            let current = 0;
            const interval = 8000;

            function next() {
                slides[current].classList.remove('active');
                dots[current].classList.remove('active');
                current = (current + 1) % slides.length;
                slides[current].classList.add('active');
                dots[current].classList.add('active');
            }

            setInterval(next, interval);
        })();
    </script>
</body>
</html>
