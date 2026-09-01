<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Board Video</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            color: #ffffff;
            background: #0a1e3c;
        }

        .board {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== MAIN ===== */
        .main {
            flex: 1;
            display: flex;
            min-height: 0;
        }

        /* ----- KIRI ----- */
        .left-panel {
            width: 25%;
            background: linear-gradient(180deg, #0d2b5e 0%, #0a1e3c 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 3vh 2vw;
            position: relative;
        }

        .left-top {
            text-align: center;
        }

        .logo-company {
            height: 11vh;
            max-width: 70%;
            object-fit: contain;
            margin-bottom: 2vh;
        }

        .clock {
            font-size: 7rem;
            font-weight: 700;
            line-height: 1;
            letter-spacing: 0.02em;
            color: #6fb7ff;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .date-str {
            margin-top: 1.5vh;
            font-size: 3.2rem;
            font-weight: 500;
            color: #d9e8ff;
        }

        .left-bottom {
            width: 100%;
            text-align: center;
            margin-top: 3vh;
            padding-bottom: 8vh;
        }

        .break-title {
            font-size: 3rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #a9c9ff;
            border-bottom: 3px solid #2f6fd0;
            display: inline-block;
            padding-bottom: 0.8vh;
            margin-bottom: 2vh;
        }

        .break-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 3vh;
            align-items: center;
        }

        .break-list li {
            font-size: 2.8rem;
            font-weight: 600;
            color: #ffffff;
            background: rgba(47, 111, 208, 0.25);
            border: 1px solid rgba(111, 183, 255, 0.5);
            border-radius: 12px;
            padding: 0.3vh 1.6vw;
            min-width: 5.5vw;
            text-align: center;
        }

        /* dots / slideshow indicator */
        .dots {
            position: absolute;
            bottom: 3vh;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 0.8vw;
        }

        .dot {
            width: 1.1vw;
            height: 1.1vw;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.35);
            transition: background 0.3s, transform 0.3s;
        }

        .dot.active {
            background: #6fb7ff;
            transform: scale(1.35);
        }

        /* ----- KANAN ----- */
        .right-panel {
            width: 75%;
            position: relative;
            background: #000000;
            overflow: hidden;
        }

        .right-panel video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .right-panel video.active {
            display: block;
        }

        .no-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #a9c9ff;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #173e83;
            padding: 1vh 2vw;
            text-align: center;
            border-top: 4px solid #2f6fd0;
            z-index: 10;
        }

        .footer-brand {
            font-size: 7rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: #ffffff;
        }

        .footer-company {
            font-size: 2.6rem;
            font-weight: 400;
            letter-spacing: 0.05em;
            color: #cfe0ff;
        }
    </style>
</head>

<body>
    <div class="board">
        <div class="main">
            <div class="left-panel">
                <div class="left-top">
                    <?php if ($showLogo): ?>
                        <img src="<?= base_url($logoPath); ?>" alt="Logo Perusahaan" class="logo-company">
                    <?php endif; ?>
                    <div class="clock" id="clock">--:--:--</div>
                    <div class="date-str" id="dateStr">&nbsp;</div>
                </div>

                <div class="left-bottom">
                    <div class="break-title">Jadwal Istirahat</div>
                    <ul class="break-list">
                        <?php foreach ($breakSchedule as $time) : ?>
                            <li><?= $time; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="dots" id="dots"></div>
                </div>
            </div>

            <div class="right-panel" id="videoPanel">
                <?php if (empty($videos)) : ?>
                    <div class="no-video">Tidak ada video</div>
                <?php else : ?>
                    <?php foreach ($videos as $v) : ?>
                        <video class="video-item" src="<?= base_url('assets/video/' . $v); ?>" muted playsinline preload="auto"></video>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer">
            <div class="footer-brand"><?= $footerBrand; ?></div>
            <div class="footer-company"><?= $footerCompany; ?></div>
        </div>
    </div>

    <script>
        // ===== Jam Realtime =====
        function two(n) {
            return String(n).padStart(2, '0');
        }

        function tickClock() {
            var now = new Date();
            var h = two(now.getHours());
            var m = two(now.getMinutes());
            var s = two(now.getSeconds());
            document.getElementById('clock').textContent = h + ':' + m + ':' + s;

            var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            document.getElementById('dateStr').textContent =
                days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
        }

        tickClock();
        setInterval(tickClock, 1000);

        // ===== Slideshow Video =====
        (function() {
            var videos = document.querySelectorAll('.video-item');
            if (videos.length === 0) return;

            var dotsWrap = document.getElementById('dots');
            videos.forEach(function(v, i) {
                var dot = document.createElement('div');
                dot.className = 'dot' + (i === 0 ? ' active' : '');
                dot.dataset.index = i;
                dot.style.cursor = 'pointer';
                dot.addEventListener('click', function() {
                    showVideo(i);
                });
                dotsWrap.appendChild(dot);
            });
            var dots = dotsWrap.children;

            var current = 0;

            function showVideo(index) {
                videos[current].classList.remove('active');
                videos[current].pause();
                current = index % videos.length;
                var v = videos[current];
                v.currentTime = 0;
                v.play();
                v.classList.add('active');

                for (var i = 0; i < dots.length; i++) {
                    dots[i].classList.toggle('active', i === current);
                }
            }

            videos.forEach(function(v, i) {
                v.addEventListener('ended', function() {
                    showVideo(i + 1);
                });
                v.addEventListener('error', function() {
                    showVideo(i + 1);
                });
            });

            showVideo(0);
        })();
    </script>
</body>

</html>
