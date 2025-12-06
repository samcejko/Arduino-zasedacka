<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Paper Mirror</title>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #111;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            cursor: none;
        }

        #e-ink {
            width: 800px;
            height: 600px;
            background-color: #e8e8e8;
            color: #111;
            position: relative;
            font-family: 'VT323', monospace;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.8);
            border: 16px solid #e8e8e8;
            outline: 2px solid #999;
        }

        #e-ink.inverted {
            background-color: #111;
            color: #e8e8e8;
            border-color: #111;
        }

        .header-bar {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background-color: #111;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        #e-ink.inverted .header-bar {
            background-color: #e8e8e8;
        }

        .header-text {
            font-size: 40px;
            color: #e8e8e8;
            text-transform: uppercase;
        }

        #e-ink.inverted .header-text {
            color: #111;
        }

        .header-right {
            display: flex;
            gap: 20px;
            align-items: center;
            color: #e8e8e8;
            font-size: 40px;
        }

        #e-ink.inverted .header-right {
            color: #111;
        }

        .main-status {
            position: absolute;
            top: 140px;
            left: 40px;
            font-size: 90px;
            text-transform: uppercase;
            line-height: 1;
        }

        .divider {
            position: absolute;
            top: 240px;
            left: 40px;
            width: 720px;
            height: 4px;
            background-color: #111;
        }

        #e-ink.inverted .divider {
            background-color: #e8e8e8;
        }

        .details-container {
            position: absolute;
            top: 260px;
            left: 40px;
            width: 450px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .detail-row {
            font-size: 36px;
        }

        .logos-container {
            position: absolute;
            bottom: 30px;
            right: 40px;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .dynamic-icon {
            width: auto;
            height: 80px;
            image-rendering: pixelated;
            transition: filter 0.2s;
        }

        #e-ink.inverted .dynamic-icon {
            filter: invert(1);
        }
    </style>
</head>

<body>
    <div id="e-ink" class="state-free">
        <div class="header-bar">
            <div class="header-text">ZASEDACKA</div>
            <div class="header-right">
                <span id="clock">--:--</span>
            </div>
        </div>
        <div class="main-status" id="status-text"></div>
        <div class="divider"></div>
        <div class="details-container" id="details-box"></div>
        <div class="logos-container">
            <!-- TODO: Replace these image URLs with your own -->
            <img src="https://placehold.co/120x120?text=QR" class="dynamic-icon" style="height: 120px;">
            <img src="https://placehold.co/120x120?text=LOGO" class="dynamic-icon" style="height: 120px;">
        </div>
    </div>
    <script>
        const API_URL = 'api.php';
        const removeDiacritics = (str) => {
            return str ? str.normalize("NFD").replace(/[\u0300-\u036f]/g, "") : "";
        }
        function updateScreen() {
            fetch(API_URL)
                .then(response => response.json())
                .then(data => { renderData(data); })
                .catch(err => console.error('Chyba:', err));
        }
        function renderData(data) {
            const screen = document.getElementById('e-ink');
            const statusText = document.getElementById('status-text');
            const detailsBox = document.getElementById('details-box');
            const clock = document.getElementById('clock');
            clock.innerText = data.cas_ted;
            if (data.stav === "OBSAZENO") {
                screen.classList.add('inverted');
                statusText.innerText = "OBSAZENO";
                let org = data.organizator ? removeDiacritics(data.organizator) : "-";
                let akce = data.kdo ? removeDiacritics(data.kdo) : "";
                detailsBox.innerHTML = `
                    <div class="detail-row">${org}</div>
                    <div class="detail-row">${akce}</div>
                    <div class="detail-row">${data.do_kdy}</div>
                `;
            } else {
                screen.classList.remove('inverted');
                statusText.innerText = "VOLNO";
                if (data.dalsi_kdo) {
                    let dalsiAkce = removeDiacritics(data.dalsi_kdo);
                    detailsBox.innerHTML = `
                        <div class="detail-row" style="font-size:24px">Dalsi: ${data.dalsi_start}</div>
                        <div class="detail-row">${dalsiAkce}</div>
                    `;
                } else {
                    detailsBox.innerHTML = `<div class="detail-row">Zadne dalsi plany</div>`;
                }
            }
        }
        document.addEventListener('keydown', (e) => {
            if (e.key === 'f' || e.key === 'F') {
                if (!document.fullscreenElement) document.documentElement.requestFullscreen();
                else if (document.exitFullscreen) document.exitFullscreen();
            }
        });
        updateScreen();
        setInterval(updateScreen, 5000);
    </script>
</body>

</html>