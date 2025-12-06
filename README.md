# Meeting Room Reservation System

A comprehensive, Retro/Matrix-styled reservation system originally designed for a FabLab/Meeting Room. It features a lightweight PHP web interface and hardware integration for E-paper status displays.

## 🚀 Features

### 💻 Web Interface
- **Desktop Dashboard** (`index.php`):
  - "Retro/Cyberpunk" aesthetic.
  - Weekly calendar view (via FullCalendar).
  - Real-time status dashboard (Free/Busy, Current Event, Next Event).
- **Mobile Version** (`mobil.php`):
  - Optimized for touch devices.
  - Simplified daily view.
  - Add/Edit reservations on the go.

### 🔌 Hardware Integration (IoT)
- **E-Ink Display** (`fablab.ino`):
  - C++ firmware for ESP32/Arduino.
  - Fetches data from the API to show room status on a low-power E-paper screen.
  - Smart WiFi connection handling and OTA updates ready.
- **Magic Mirror / Info Screen** (`mirror.php`):
  - High-contrast, large-font display mode.
  - Designed for dedicated tablets or smart mirrors outside the room.

### ⚙️ Backend
- **Zero-Config Database**: Uses a flat JSON file (`events.json`) for data storage. No MySQL/PostgreSQL required.
- **JSON API** (`api.php`): Exposes normalized data for 3rd party integrations or hardware.

## 🛠️ Installation

1.  **Server Requirements**: Any web server with **PHP 7.4+**.
2.  **Upload**: Copy all files to your web server directory.
3.  **Permissions**:
    *   Ensure `events.json` is **writable** by the web server.
    *   *Example command:* `chmod 777 events.json` (or `chown www-data events.json` depending on your security needs).

## 🔧 Configuration

### Timezone
By default, the system is set to `Europe/Prague`. You can change this in `api.php`:
```php
date_default_timezone_set('Europe/Prague');
```

### Hardware (ESP32)
1.  Open `fablab.ino` in the Arduino IDE.
2.  Install required libraries: `GxEPD2`, `Adafruit_GFX`, `ArduinoJson`.
3.  Fill in your WiFi credentials and server URL in the configuration section:
    ```cpp
    WifiInfo networks[] = { {"YOUR_SSID", "YOUR_PASS"} };
    const char* server = "your-domain.com";
    ```
4.  Upload to your board.

## 🤝 Contributing
Feel free to fork this repository and submit pull requests.

## 📄 License
This project is open source.
