<!DOCTYPE html>
<html lang='cs'>

<head>
  <meta charset='utf-8' />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Zasedačka Panel</title>

  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --bg-color: #ffffff;
      --text-color: #000000;
    }

    body {
      background-color: var(--bg-color);
      color: var(--text-color);
      font-family: 'Press Start 2P', monospace;
      padding: 20px;
      line-height: 1.5;
      image-rendering: pixelated;
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: repeating-linear-gradient(0deg, rgba(0, 0, 0, 0.03) 0px, rgba(0, 0, 0, 0.03) 1px, transparent 1px, transparent 2px);
      pointer-events: none;
      z-index: 1000;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    h1 {
      text-transform: uppercase;
      border: 4px solid black;
      padding: 20px;
      font-weight: normal;
      text-align: center;
      letter-spacing: 2px;
      margin-bottom: 20px;
      font-size: 18px;
      background: #ffffff;
      box-shadow: 6px 6px 0 #000000;
    }

    /* --- NOVÝ DASHBOARD (STAV) --- */
    .dashboard {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
      border: 4px solid black;
      padding: 15px;
      background: #eee;
      box-shadow: 6px 6px 0 #000000;
      flex-wrap: wrap;
    }

    .dash-box {
      flex: 1;
      min-width: 250px;
      background: white;
      border: 2px solid black;
      padding: 10px;
    }

    .dash-label {
      font-size: 10px;
      margin-bottom: 5px;
      text-transform: uppercase;
      border-bottom: 2px solid black;
      padding-bottom: 5px;
    }

    .dash-value {
      font-family: 'Courier New', monospace;
      font-size: 16px;
      font-weight: bold;
      margin-top: 5px;
      line-height: 1.2;
    }

    /* Styly pro stav */
    .status-free {
      color: black;
      background: white;
    }

    .status-busy {
      color: white;
      background: black;
      padding: 2px 5px;
    }

    #calendar {
      max-width: 100%;
      margin: 0 auto 30px;
      height: 70vh;
      border: 4px solid #000000;
      padding: 10px;
      background: #ffffff;
      box-shadow: 6px 6px 0 #000000;
    }

    /* --- KALENDÁŘ --- */
    .fc {
      font-family: 'Press Start 2P', monospace !important;
      font-size: 10px;
    }

    .fc-toolbar-title {
      font-size: 14px !important;
      padding: 10px 0;
    }

    .fc td,
    .fc th {
      border: 2px solid black !important;
    }

    .fc-timegrid-slot {
      border-bottom: 1px solid black !important;
      height: 2.5em !important;
    }

    .fc-button {
      border-radius: 0 !important;
      text-transform: uppercase;
      border: 3px solid black !important;
      box-shadow: 3px 3px 0 #000000 !important;
      font-family: 'Press Start 2P', monospace !important;
      font-size: 9px !important;
      padding: 10px 10px !important;
      background: #ffffff !important;
      color: #000000 !important;
      margin: 2px !important;
    }

    .fc-button:hover,
    .fc-button-active {
      color: white !important;
      background-color: black !important;
      transform: translate(2px, 2px);
      box-shadow: 1px 1px 0 #000000 !important;
    }

    .fc-event {
      border-radius: 0 !important;
      border: 2px solid black !important;
      cursor: pointer;
      background: #000000 !important;
      box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.2);
      padding: 2px !important;
    }

    .fc-event-main {
      display: flex !important;
      flex-direction: row !important;
      align-items: center !important;
      flex-wrap: wrap !important;
      gap: 6px;
      color: #ffffff !important;
      font-size: 11px !important;
      line-height: 1.3 !important;
      font-family: 'Courier New', monospace !important;
      font-weight: bold;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
    }

    .fc-event-time {
      font-size: 11px !important;
      border: none !important;
      margin: 0 !important;
      width: auto !important;
      white-space: nowrap;
      background: white;
      color: black;
      padding: 2px 4px;
      font-weight: bold;
    }

    .fc-day-today {
      background-image: repeating-linear-gradient(45deg, #ffffff, #ffffff 10px, #eeeeee 10px, #eeeeee 12px) !important;
    }

    .fc-now-indicator-line {
      border-color: black !important;
      border-width: 3px 0 0 0 !important;
    }

    .fc-now-indicator-arrow {
      border-color: black !important;
      border-width: 8px 0 8px 8px !important;
    }

    .retro-link {
      display: inline-block;
      border: 3px solid black;
      color: black;
      background: white;
      padding: 15px 20px;
      text-decoration: none;
      font-size: 10px;
      box-shadow: 5px 5px 0 #000000;
      transition: all 0.1s;
    }

    .retro-link:hover {
      background-color: black;
      color: white;
      transform: translate(2px, 2px);
      box-shadow: 3px 3px 0 #000000;
    }

    .button-container {
      text-align: center;
      margin-top: 20px;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 2000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-content {
      background-color: #ffffff;
      margin: 10% auto;
      padding: 0;
      border: 4px solid #000;
      box-shadow: 8px 8px 0 #000;
      width: 90%;
      max-width: 500px;
    }

    .modal-header {
      padding: 15px;
      background: #000;
      color: #fff;
      font-size: 12px;
      text-transform: uppercase;
      border-bottom: 4px solid #000;
    }

    .modal-body {
      padding: 20px;
    }

    .modal-footer {
      padding: 15px;
      border-top: 4px solid #000;
      text-align: right;
    }

    .modal-input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 3px solid #000;
      font-family: 'Courier New', monospace;
      font-size: 12px;
      box-shadow: 3px 3px 0 #000;
    }

    .modal-label {
      display: block;
      margin-top: 10px;
      margin-bottom: 5px;
      font-size: 10px;
      text-transform: uppercase;
    }

    .modal-btn {
      border: 3px solid black;
      padding: 10px 15px;
      font-family: 'Press Start 2P', monospace;
      font-size: 9px;
      background: white;
      color: black;
      cursor: pointer;
      box-shadow: 3px 3px 0 #000;
      margin-left: 5px;
      text-transform: uppercase;
    }

    .modal-btn:hover {
      background: black;
      color: white;
      transform: translate(2px, 2px);
      box-shadow: 1px 1px 0 #000;
    }

    .modal-btn-danger {
      background: #ff0000;
      color: white;
    }

    .modal-btn-danger:hover {
      background: #cc0000;
    }

    .close {
      color: white;
      float: right;
      font-size: 20px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover {
      color: #ccc;
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 12px;
        padding: 15px;
      }

      .dashboard {
        flex-direction: column;
        gap: 10px;
      }

      .fc-toolbar {
        flex-direction: column;
        gap: 10px;
      }

      .fc {
        font-size: 8px;
      }

      .fc-toolbar-title {
        font-size: 11px !important;
      }

      .fc-button {
        font-size: 7px !important;
        padding: 8px 6px !important;
      }

      .fc-event-main {
        font-size: 9px !important;
      }

      .fc-event-time {
        font-size: 9px !important;
      }

      #calendar {
        height: 60vh;
      }

      .modal-content {
        width: 95%;
        margin: 20% auto;
      }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var calendarEl = document.getElementById('calendar');
      var isMobile = window.innerWidth < 768;
      var calendar;
      function updateDashboard() {
        var now = new Date();
        var allEvents = calendar.getEvents();

        var currentEvent = null;
        var nextEvent = null;
        var minDiffNext = Infinity;

        allEvents.forEach(function (event) {
          var start = event.start;
          var end = event.end;

          if (now >= start && now < end) currentEvent = event;

          if (start > now) {
            var diff = start - now;
            if (diff < minDiffNext) {
              minDiffNext = diff;
              nextEvent = event;
            }
          }
        });

        var elStav = document.getElementById('dash-stav');
        var elKdo = document.getElementById('dash-kdo');
        var elDalsi = document.getElementById('dash-dalsi');

        if (currentEvent) {
          elStav.innerHTML = "<span class='status-busy'>OBSAZENO</span>";
          var remainingMins = Math.ceil((currentEvent.end - now) / 60000);
          let orgInfo = currentEvent.extendedProps.organizer ? ` (${currentEvent.extendedProps.organizer})` : "";
          elKdo.innerHTML = currentEvent.title + orgInfo + "<br><small>Do konce: " + remainingMins + " min</small>";
        } else {
          elStav.innerHTML = "VOLNO";
          elKdo.innerHTML = "--";
        }

        if (nextEvent) {
          var hours = String(nextEvent.start.getHours()).padStart(2, '0');
          var mins = String(nextEvent.start.getMinutes()).padStart(2, '0');
          elDalsi.innerHTML = hours + ":" + mins + " | " + nextEvent.title;
        } else {
          elDalsi.innerHTML = "Zadne dalsi plany";
        }
      }

      function checkOverlap(start, end, excludeEventId) {
        return calendar.getEvents().some(function (event) {
          if (excludeEventId && String(event.id) === String(excludeEventId)) return false;
          return start < event.end && end > event.start;
        });
      }

      calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: isMobile ? 'timeGridDay' : 'timeGridWeek',
        locale: 'cs',
        slotMinTime: "00:00:00", slotMaxTime: "24:00:00", scrollTime: "07:00:00", slotDuration: "00:30:00",
        allDaySlot: false, nowIndicator: true,

        headerToolbar: {
          left: 'prev,next today', center: 'title', right: isMobile ? '' : 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        buttonText: {
          today: 'Dnes',
          month: 'Měsíc',
          week: 'Týden',
          day: 'Den',
          prev: 'Předchozí',
          next: 'Další'
        },

        navLinks: true, selectable: true, selectMirror: true, events: 'events.json',

        eventsSet: function () { updateDashboard(); },

        select: function (arg) {
          showAddEventModal(arg.start, arg.end);
          calendar.unselect();

        },

        eventClick: function (arg) {
          showEventDetailsModal(arg.event);
        },

        eventDrop: function (info) {
          if (checkOverlap(info.event.start, info.event.end, info.event.id)) {
            alert("❌ CHYBA: Čas je již obsazený!\nZvolte prosím jiný termín.");
            info.revert();
          } else {
            saveData();
          }
        },

        eventResize: function (info) {
          if (checkOverlap(info.event.start, info.event.end, info.event.id)) {
            alert("❌ CHYBA: Čas je již obsazený!\nZvolte prosím jiný rozsah.");
            info.revert();
          } else {
            saveData();
          }
        }
      });

      calendar.render();
      setInterval(updateDashboard, 10000);

      function saveData() {
        var events = calendar.getEvents().map(function (e) {
          return {
            id: e.id,
            title: e.title,
            start: e.start.toISOString(),
            end: e.end ? e.end.toISOString() : null,
            organizer: e.extendedProps.organizer || ""
          };
        });

        fetch('save.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(events)
        }).then(response => {
          console.log("DATA ULOŽENA");
          updateDashboard();
        }).catch(error => {
          alert("❌ Chyba připojení!\nNepodařilo se uložit data na server.");
        });
      }
      function formatDateTime(date) {
        const pad = n => String(n).padStart(2, '0');
        return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
      }

      function showAddEventModal(start, end) {
        var modal = document.getElementById('addEventModal');
        document.getElementById('eventTitle').value = '';
        document.getElementById('eventOrg').value = '';
        document.getElementById('eventStart').value = formatDateTime(start);
        document.getElementById('eventEnd').value = formatDateTime(end);
        modal.style.display = 'block';
      }

      window.saveNewEvent = function () {
        var title = document.getElementById('eventTitle').value;
        var org = document.getElementById('eventOrg').value;
        var start = new Date(document.getElementById('eventStart').value);
        var end = new Date(document.getElementById('eventEnd').value);

        if (!title) {
          alert('⚠️ Zadejte prosím název akce!');
          return;
        }

        if (start >= end) {
          alert('❌ CHYBA: Začátek musí být před koncem!');
          return;
        }

        if (checkOverlap(start, end)) {
          alert('❌ CHYBA: Čas je již obsazený!\nZvolte prosím jiný termín.');
          return;
        }

        calendar.addEvent({
          id: Date.now(),
          title: title,
          start: start,
          end: end,
          extendedProps: { organizer: org }
        });
        saveData();
        closeAddEventModal();
      };

      window.closeAddEventModal = function () {
        document.getElementById('addEventModal').style.display = 'none';
      };

      var currentEvent = null;
      function showEventDetailsModal(event) {
        currentEvent = event;
        var modal = document.getElementById('eventDetailsModal');
        document.getElementById('detailTitle').value = event.title;
        document.getElementById('detailOrg').value = event.extendedProps.organizer || "";
        document.getElementById('detailStart').value = formatDateTime(event.start);
        document.getElementById('detailEnd').value = formatDateTime(event.end);

        var startStr = event.start.toLocaleString('cs-CZ');
        var endStr = event.end.toLocaleString('cs-CZ');
        document.getElementById('eventInfo').innerHTML =
          '<strong>Začátek:</strong> ' + startStr + '<br>' +
          '<strong>Konec:</strong> ' + endStr;

        modal.style.display = 'block';
      }

      window.updateEvent = function () {
        if (!currentEvent) return;

        var title = document.getElementById('detailTitle').value;
        var org = document.getElementById('detailOrg').value;
        var start = new Date(document.getElementById('detailStart').value);
        var end = new Date(document.getElementById('detailEnd').value);

        if (!title) {
          alert('⚠️ Zadejte prosím název akce!');
          return;
        }

        if (start >= end) {
          alert('❌ CHYBA: Začátek musí být před koncem!');
          return;
        }

        if (checkOverlap(start, end, currentEvent.id)) {
          alert('❌ CHYBA: Čas je již obsazený!\nZvolte prosím jiný termín.');
          return;
        }

        currentEvent.setProp('title', title);
        currentEvent.setExtendedProp('organizer', org);
        currentEvent.setStart(start);
        currentEvent.setEnd(end);
        saveData();
        closeEventDetailsModal();
      };

      window.deleteEvent = function () {
        if (!currentEvent) return;
        if (confirm('OPRAVDU SMAZAT: "' + currentEvent.title + '"?')) {
          currentEvent.remove();
          saveData();
          closeEventDetailsModal();
        }
      };

      window.closeEventDetailsModal = function () {
        document.getElementById('eventDetailsModal').style.display = 'none';
        currentEvent = null;
      };

      window.onclick = function (event) {
        var addModal = document.getElementById('addEventModal');
        var detailsModal = document.getElementById('eventDetailsModal');
        if (event.target == addModal) {
          closeAddEventModal();
        }
        if (event.target == detailsModal) {
          closeEventDetailsModal();
        }
      };
    });
  </script>
</head>

<body>
  <div class="container">
    <div style="text-align: center; margin-bottom: 10px;">
      <a href="mobil.php" class="retro-link" style="display:inline-block;">OTEVŘÍT MOBILNÍ VERZI</a>
    </div>

    <h1>REZERVACE ZASEDAČKY</h1>

    <div class="dashboard">
      <div class="dash-box">
        <div class="dash-label">NYNI:</div>
        <div class="dash-value" id="dash-stav">NACITAM...</div>
      </div>
      <div class="dash-box">
        <div class="dash-label">AKTUÁLNÍ AKCE:</div>
        <div class="dash-value" id="dash-kdo">--</div>
      </div>
      <div class="dash-box">
        <div class="dash-label">NASLEDUJICI:</div>
        <div class="dash-value" id="dash-dalsi">--</div>
      </div>
    </div>

    <div id='calendar'></div>

    <div class="button-container">
      <a href="api.php" target="_blank" class="retro-link">ZOBRAZIT API DATA</a>
    </div>
  </div>

  <div id="addEventModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="close" onclick="closeAddEventModal()">&times;</span>
        Nová rezervace
      </div>
      <div class="modal-body">
        <label class="modal-label">Název akce:</label>
        <input type="text" id="eventTitle" class="modal-input" placeholder="Zadejte název...">

        <label class="modal-label">Organizátor (Kdo):</label>
        <input type="text" id="eventOrg" class="modal-input" placeholder="Jméno...">

        <label class="modal-label">Čas od:</label>
        <input type="datetime-local" id="eventStart" class="modal-input">

        <label class="modal-label">Čas do:</label>
        <input type="datetime-local" id="eventEnd" class="modal-input">
      </div>
      <div class="modal-footer">
        <button class="modal-btn" onclick="closeAddEventModal()">Zrušit</button>
        <button class="modal-btn" onclick="saveNewEvent()">Přidat</button>
      </div>
    </div>
  </div>

  <div id="eventDetailsModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="close" onclick="closeEventDetailsModal()">&times;</span>
        Detail rezervace
      </div>
      <div class="modal-body">
        <div id="eventInfo" style="margin-bottom: 15px; padding: 10px; background: #eee; border: 2px solid #000;"></div>

        <label class="modal-label">Název akce:</label>
        <input type="text" id="detailTitle" class="modal-input">

        <label class="modal-label">Organizátor (Kdo):</label>
        <input type="text" id="detailOrg" class="modal-input">

        <label class="modal-label">Čas od:</label>
        <input type="datetime-local" id="detailStart" class="modal-input">

        <label class="modal-label">Čas do:</label>
        <input type="datetime-local" id="detailEnd" class="modal-input">
      </div>
      <div class="modal-footer">
        <button class="modal-btn modal-btn-danger" onclick="deleteEvent()">Smazat</button>
        <button class="modal-btn" onclick="closeEventDetailsModal()">Zrušit</button>
        <button class="modal-btn" onclick="updateEvent()">Uložit</button>
      </div>
    </div>
  </div>
</body>

</html>