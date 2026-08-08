# Tesvrix  — Complete Setup Guide (Local Hosting)

This guide explains how to host the whole TesvrixV2 system **on your own PC** and expose it to the internet with Cloudflare quick tunnels — no paid hosting needed.

It covers everything from scratch: installing tools, creating the database, running the server, running the web panel, connecting it all through tunnels, configuring the Android APK, and building it.

> All values in `<ANGLE BRACKETS>` are placeholders. Replace them with **your own** values. Never share your real tokens/keys with anyone.

---

## Table of Contents

1. [How the system works](#1-how-the-system-works)
2. [What you need (tools)](#2-what-you-need-tools)
3. [Step 1 — Create the database (Supabase)](#step-1--create-the-database-supabase)
4. [Step 2 — Run the relay server (Node.js)](#step-2--run-the-relay-server-nodejs)
5. [Step 3 — Run the web panel (PHP)](#step-3--run-the-web-panel-php)
6. [Step 4 — Expose everything with Cloudflare tunnels](#step-4--expose-everything-with-cloudflare-tunnels)
7. [Step 5 — Configure the APK (change URL / IP / tokens)](#step-5--configure-the-apk-change-url--ip--tokens)
8. [Step 6 — Build the APK](#step-6--build-the-apk)
9. [Step 7 — Install and verify](#step-7--install-and-verify)
10. [Troubleshooting](#troubleshooting)
11. [Making it permanent (auto-start, stable URL)](#making-it-permanent-auto-start-stable-url)
12. [Security checklist](#security-checklist)

---

## 1. How the system works

The system has **4 parts**:

```
┌─────────────┐       ┌──────────────────┐       ┌──────────────┐
│ Android APK │ ────► │  RELAY (Node.js) │ ────► │  SUPABASE DB │
│ (target     │  APP  │  runs on your PC │ REST  │ (cloud, free)│
│  device)    │ token │  port 10000      │       │              │
└─────────────┘       └───────┬──────────┘       └──────────────┘
                              │
        ┌─────────────────────┘
        ▼
┌──────────────────┐       ┌──────────────┐
│  WEB PANEL (PHP) │  REST │  RELAY again │
│  on your PC      │ token │  (same relay)│
│  port 8080       │ ─────► │              │
└──────────────────┘       └──────────────┘
```

- **APK (Android)** — the agent installed on the target device. It phones home to the *relay* with its APP token.
- **Relay (Node.js)** — a middle-man running on your PC. It checks the token of whoever connects, then forwards database requests to Supabase. It also runs the realtime data (screen sharing, etc).
- **Web Panel (PHP)** — the control panel you open in a browser. It also talks to the relay (with the WEB token) and the relay forwards queries to Supabase.
- **Supabase** — a free cloud PostgreSQL database. Stores devices, commands, and settings. Free tier is enough.

Why a relay at all? So the APK and the panel never need your real Supabase database URL/keys — they only know the relay address, and the relay checks tokens before forwarding anything. The real database credentials stay private on your PC.

---

## 2. What you need (tools)

All of these run on **Windows**. You need:

| Tool | Why | Version used here |
|---|---|---|
| Node.js | The relay server | v24 (any recent LTS works) |
| PHP | The web panel | 8.1+ |
| Java (JDK) 17 | To compile the APK | Temurin 17 |
| Android SDK + platform-tools | To compile the APK | android-35, build-tools 35 |
| Gradle 9.5.1 | APK build tool | 9.5.1 |
| cloudflared | Free public tunnels | any recent release |
| Supabase account | Free cloud database | free tier |
| An Android phone | Target device | Android 8+ |
| Optional: Android Studio | Easier APK building | any recent version |

### Installing quickly

- **Node.js** → download the Windows LTS installer from nodejs.org, install, verify:
  ```powershell
  node --version
  npm --version
  ```
- **PHP** → download from php.org (Windows zip), extract, add php.exe folder to PATH, verify:
  ```powershell
  php --version
  ```
- **Java 17** → install Temurin 17 (adoptium.net), verify:
  ```powershell
  java -version
  ```
- **Android SDK** → you can either install Android Studio (it bundles the SDK at `C:\Android\Sdk` or `%LOCALAPPDATA%\Android\Sdk`) or download "command line tools" only. The SDK folder must contain `platforms\` and `build-tools\`.
- **Gradle** → download the `bin` zip from gradle.org/releases, unzip anywhere (example: `C:\Users\<you>\gradle\gradle-9.5.1`). You don't need the system install everywhere: the build script uses this exact folder.
- **cloudflared** → download `cloudflared-windows-amd64.exe` from the Cloudflare GitHub releases, save it as `C:\cloudflared\cloudflared.exe` so future commands are short.

---

## Step 1 — Create the database (Supabase)

### 1.1 Create a project

1. Go to **supabase.com → Sign in → New project**.
2. Give it a name, set a strong database password, choose a region near you, create it.
3. Wait ~1 minute while it creates.

### 1.2 Get your credentials

In the Supabase dashboard, go to **Project Settings → API**:

- **Project URL** — looks like `https://abcdefghij.supabase.co`
- **Service role key** — a very long string starting with `eyJhbG...` (the role marked `service_role`)

> ⚠️ **The service role key is ALL-POWERFUL.** Anyone who has it can erase your whole DB. Only the relay on your PC needs it. Never paste it into the APK or the panel.

### 1.3 Create the tables

1. In Supabase dashboard go to **SQL Editor → New query**.
2. Open the SQL file that came with the project: `setup_tables.sql` (in the APK src folder).
3. Paste the whole content, press **Run**.

This creates: `devices`, `commands`, `vault`, `operators`, `settings` (and helpers). Wait for "Success."

### 1.4 Create your operator (admin/login)

An **operator** is a person allowed to log into the panel. Each operator has a `operator_id` — the same ID the device sends, so devices appear only to the correct operator.

Run this in **SQL Editor** (change username/password/the number to your own):

```sql
INSERT INTO operators (username, password, telegram_channel_id, expiry_date)
VALUES ('admin', 'change_this_password', -123456789, NOW() + INTERVAL '1 year');
```

- `username` + `password` → what you log into the panel with (stored plainly in this version).
- `telegram_channel_id` → a private ID. **Write it down, the APK needs to use it later in Step 5.**

> A simple test row would be `VALUES ('admin', 'admin123',-1000000000000, NOW() + INTERVAL '1 year');` — but change the password before anything real.

---

## Step 2 — Run the relay server (Node.js)

### 2.1 Get the server code

Inside your project folder you have a `Serverbackend` folder (or `Server`). Copy it to where you want the site to live, e.g. `C:\tesvrix\relay`.

### 2.2 Install dependencies

Open PowerShell in the relay folder and run:

```powershell
cd C:\tesvrix\relay
npm install
```

This downloads everything it needs (express.js etc), usually ~30 packages.

### 2.3 Create the config file (run script)

The relay reads settings from **environment variables** at start. Make a PowerShell script `run-relay.ps1` in the same folder:

```powershell
$ErrorActionPreference = "Continue"
$env:PORT = "10000"
$env:SUPABASE_URL = "https://<your-project>.supabase.co"
$env:SUPABASE_KEY = "<your service_role key long string>"
$env:APP_ACCESS_TOKEN = "<random string for devices>"
$env:WEB_ACCESS_TOKEN = "<random string for the panel>"
$env:TELEGRAM_TOKEN = ""

node index.js
```

What each one means:

| Variable | Meaning |
|---|---|
| `PORT` | What port the relay listens on locally. Be consistent (we use 10000 here). |
| `SUPABASE_URL` | Your Supabase project URL |
| `SUPABASE_KEY` | The service role key |
| `APP_ACCESS_TOKEN` | Secret that **the APK** (device) must know. Invent a random string. |
| `WEB_ACCESS_TOKEN` | Secret that **the panel** must know. Invent another random string. |
| `TELEGRAM_TOKEN` | Optional Telegram bot token for alerts. Empty = disabled. |

Generate good random tokens in PowerShell:

```powershell
-join ((48..57) + (97..122) | Get-Random -Count 32 | ForEach-Object {[char]$_})
```

Run it twice → you have two different 32-char strings.

### 2.4 Start the relay

```powershell
powershell -ExecutionPolicy Bypass -File .\run-relay.ps1
```

Keep that window open (do not close it). Verify it's up with a browser or:

```powershell
Invoke-WebRequest http://localhost:10000/health
```

Expected: `{"status":"online"}`.

**How the token check works in the relay:** every request from the device or panel must include the header `x-access-token` (or `?token=` in the URL). If the token matches `APP_ACCESS_TOKEN` or `WEB_ACCESS_TOKEN` → allowed → forwarded to Supabase. If not → HTTP **403 Access Denied**. (That's the most common mistake — wrong/empty token.)

**Default fallback:** if you start `node index.js` without environment variables, the relay uses hard-coded default tokens so it "works" on a fresh install — but those defaults are public, so always run `run-relay.ps1` instead.

---

## Step 3 — Run the web panel (PHP)

### 3.1 Copy the panel folder

The project contains a `webpanel` source folder. Copy the content (index.php, sections/, etc.) to a folder like `C:\tesvrix\panel`.

### 3.2 Configure the connection to the relay

Open `config.php` (it lives in a subfolder of the panel, e.g. `panel\configholder\config.php`) and set:

```php
$proxy_url = 'http://localhost:10000';   // your relay (later, its public tunnel URL)
$web_token = '<YOUR WEB_ACCESS_TOKEN>';  // same as the env you set above
```

### 3.3 Start the PHP server

In the panel folder (where `index.php` is), run:

```powershell
cd C:\tesvrix\panel
php -S localhost:8080
```

Keep window open. Test: browse to `http://localhost:8080` → you should see the login page.

How the panel talks to the database — every section (DEVICE STATS, CALL COMMAND, ...) makes REST requests to `getApiUrl('rest/v1/…')` (JS), which is based on `PROXY_URL`/`PROXY_TOKEN` from config.php. It always goes through the relay, never directly to Supabase.

---

## Step 4 — Expose everything with Cloudflare tunnels

Your PC is behind your internet and not publicly reachable. cloudflared creates a public URL that forwards to your local port — no router setup needed.

### 4.1 Download cloudflared

Download `cloudflared-windows-amd64.exe` from the Cloudflare GitHub releases; place it at a fixed path (e.g. `C:\cloudflared\cloudflared.exe`).

### 4.2 Tunnel #1 — for the relay

```powershell
cd C:\cloudflared
.\cloudflared.exe tunnel --url http://localhost:10000
```

After a few seconds it prints something like:

```
|  Trycloudflare.com | https://random-name.trycloudflare.com |
```

That first URL (for the relay) is **YOUR RELAY PUBLIC ADDRESS** → keep it, it goes inside the APK. It ends with `.trycloudflare.com`.

### 4.3 Tunnel #2 — for the web panel

Open a **second** PowerShell (relay tunnel and panel tunnel stay running in **separate windows**):

```powershell
cd C:\cloudflared
.\cloudflared.exe tunnel --url http://localhost:8080
```

The second URL open in the browser is **YOUR PANEL PUBLIC ADDRESS**.

> ⚠️ **Quick tunnels are temporary.** Every time you restart a cloudflared window, you get a *different* public URL. The APK has the relay URL *baked inside* — so if the relay tunnel changes, you must rebuild the APK (Step 5-6). See Section 11 for a permanent solution (named tunnel).

### 4.4 Point `config.php` at the public relay URL

Your panel works locally, but devices out in the wild can't reach `localhost:10000`. So update config.php again with the **relay public URL**:

```php
$proxy_url = 'https://your-relay-url.trycloudflare.com'; // from step 4.2
$web_token = 'YOUR WEB_ACCESS_TOKEN';
```

Restart the PHP server (Ctrl+C, run again). The panel is now fully public: anyone with your panel URL can reach the login page — protect it with a strong operator password.

---

## Step 5 — Configure the APK (change URL / IP / tokens)

Now the one big decision: type the **public relay URL** into the Android app source so the device phones home to your PC.

### Where the values live

File: `app\src\main\java\com\tesvrix\SecurityContext.java` (inside the APK source folder)

Method `getC()` returns an array:

```java
public static String[] getC() {
    return new String[]{
        "https://PASTE_RELAY_PUBLIC_URL_HERE",   // [0] base URL — NO trailing slash
        "PASTE_APP_ACCESS_TOKEN_HERE",           // [1] APP token (device)
        ""                                       // [2] unused in this config
    };
}
```

- Keep the `https://` prefix.
- **No trailing slash** (no `/` at the end) — the app adds paths itself.

### Also change the telemetry ID

In the **same file**, near the top:

```java
private static final String DEFAULT_OPERATOR_ID = "-100TG";
```

and in `app\src\main\res\values\strings.xml`:

```xml
<string name="config_channel_id">OPERATOR_ID_HERE</string>
```

Both must be **exactly the same number** — and it must be **exactly the `telegram_channel_id`** of your operator in the DB (Step 1.4). The device sends only to operators with this ID; the panel shows only devices with this ID. Everything breaks if they ever differ.

### The three values must match — checklist

| Where | Value |
|---|---|
| Supabase — operator row's `telegram_channel_id` | `<OPERATOR_ID>` |
| `SecurityContext.DEFAULT_OPERATOR_ID` | `<OPERATOR_ID>` |
| `strings.xml` `config_channel_id` | `<OPERATOR_ID>` |
| Relay env `APP_ACCESS_TOKEN` | `<APP_TOKEN>` |
| Relay env `WEB_ACCESS_TOKEN` | `<WEB_TOKEN>` |
| APK `getC()[1]` (APP token) | `<APP_TOKEN>` |
| Panel `config.php` `$web_token` | `<WEB_TOKEN>` |
| APK `getC()[0]` (URL) | `<RELAY_PUBLIC_URL>` |
| Panel `config.php` `proxy_url` | `<RELAY_PUBLIC_URL>` |

That's the whole "magic" of connecting: matching URLs + tokens + operator ID.

---

## Step 6 — Build the APK

Two ways: Command line (this is what this setup uses) or Android Studio (visual). Both compile the same result.

### 6.1 Prepare the PC

1. Java 17 installed and in path: `java -version` ✓
2. Android SDK with:

   - `platforms\android-34` or `android-35` (the project uses compile SDK 35)
   - `build-tools\35.0.0`
   - `cmdline-tools\latest\bin\sdkmanager.bat`

   If missing, install with sdkmanager (accept licenses first):

   ```powershell
   & "C:\Android\Sdk\cmdline-tools\latest\bin\sdkmanager.bat" --licenses
   & "C:\Android\Sdk\cmdline-tools\latest\bin\sdkmanager.bat" "platforms;android-35" "build-tools;35.0.0"
   ```

3. Gradle 9.5.1 unzipped somewhere (we'll call it `C:\Users\<you>\Gradle\gradle-9.5.1`).

### 6.2 Point the build at your SDK

In the project root folder there is a file called `local.properties` — it tells Gradle where your Android SDK is. If it's missing or points somewhere wrong (e.g. another machine's Linux path like `/home/user/Android/Sdk`), replace it:

```
sdk.dir=C\:\\Android\\Sdk
```

Uses double backslashes inside. (This exact step was needed when the source came from another machine with a different path.)

### 6.3 Build the APK

```powershell
cd "C:\Users\<you>\apk-source"
& "C:\Users\<you>\Gradle\gradle-9.5.1\bin\gradle.bat" assembleDebug --no-daemon
```

First run took ~6 minutes (it downloads Android Gradle Plugin + dependencies). Result `.apk`:

```
app\build\outputs\apk\debug\app-debug.apk   (~1.6 MB)
```

> The `debug` APK is auto-signed with a local debug keystore → installable on a phone right away. For a `release` build you'd need to add your own signing config (`signingConfig` with a keystore) in `app\build.gradle` first — not required for this setup.

### 6.4 Verify the config got into the APK (optional but smart)

You can extract the APK and confirm it contains your URL/token/operator ID:

```powershell
Copy-Item app\build\outputs\apk\debug\app-debug.apk C:\temp\app.zip
Expand-Archive C:\temp\app.zip C:\temp\apk_check -Force
Select-String -Path "C:\temp\apk_check\classes.dex" -Pattern "your-relay-url" 
```

If strings appear (binary search of dex files, works for ASCII), it's inside.

---

## Step 7 — Install and verify

1. **Copy** `app-debug.apk` to your phone (USB cable, or send it).
2. Tap install (allow unknown sources), open the app **once** — grant all permissions it asks for (device admin) — the app starts quietly in the background.
3. Wait ~30-60 s (heartbeat).

Then check success in two places:

**A) Database:** in Supabase → Table Editor → `devices` → a row with your phone's `device_uuid` and `operator_id` = your ID.

**B) Panel:** open your panel public URL → log in (Step 1.4 username/password) → in the panel's devices section your phone should be listed as online.

What you should NOT see:

| Symptom | Cause |
|---|---|
| No row in `devices` | URL or token in APK wrong, or device can't reach relay, or tunnel down |
| Row has operator_id wrong/empty | `config_channel_id` or `DEFAULT_OPERATOR_ID` didn't match DB |
| 403 in browser when opening relay `health` | You're using relay URL with wrong token — shouldn't be a problem for normal browsers |

---

## Troubleshooting

| Problem | Why | Fix |
|---|---|---|
| Login page opens but black screen after login | You logged into the "light" demo page (index.html with hardcoded admin/admin), not the real panel | Open the cloudflare URL for the *panel* (port 8080), not the relay; if you're on demo login, use the real creds |
| Chrome/panel says 403 / Access Denied | `x-access-token` mismatch | compare every token in Section 5 checklist; restart relay after changing env vars |
| 403 / Access Denied in panel | the panel's `$web_token` differs from the relay's `WEB_ACCESS_TOKEN` | make them identical, restart relay |
| Device never phones home | URL in APK (getC()[0]) is not your relay's tunnel URL (typo, trailing slash) | rebuild after fix |
| Health check fails on public URL | Tunnel window closed; name changed | start `cloudflared` again, use new URL, rebuild APK |
| Build errors about missing platform | SDK not installed | run sdkmanager commands in 6.1 |
| Build errors "sdk.dir" | local.properties points somewhere wrong | fix 6.2 to `C\:\\Android\\Sdk` |
| `npm install` fails / node errors | internet / node version | Node 18+; re-run |
| Disk "out of space" during build | SDK + Gradle cache need few GB | free space; Gradle stores cache in `~`.gradle (can be 1-2 GB) |

---

## Making it permanent (auto-start, stable URL)

Quick tunnels don't survive a reboot or a cloudflared restart. For permanent, long-term hosting on your home PC:

1. **Named tunnel (fixed URL).** In cloudflared:
   ```powershell
   .\cloudflared.exe tunnel login
   .\cloudflared.exe tunnel create mytesvrix
   .\cloudflared.exe tunnel route dns mytesvrix mytesvrix.yourdomain.com
   .\cloudflared.exe tunnel run --url http://localhost:10000 mytesvrix
   ```
   Then the URL never changes → the APK keeps working forever. You need a domain connected to Cloudflare for the nice URL.

2. **Auto-start everything on boot** (startup folder):
   - Create `start-relay.cmd`:
     ```
     @echo off
     cd C:\tesvrix\relay
     powershell -ExecutionPolicy Bypass -File .\run-relay.ps1
     ```
   - Create `start-php.cmd`:
     ```
     cd C:\tesvrix\panel
     php -S 127.0.0.1:8080
     ```
   - Create `start-tunnels.cmd`: run both named tunnel commands (one per service, each in its own window).
   - Place all three .cmd shortcuts into `shell:startup`.

   Every reboot they all start in separate windows → whole system online again.

3. **Stable URL = no APK rebuilds**: with a named tunnel the URL never changes, so a cloudflared restart won't break the APK.

---

## Security checklist

- [ ] Replace every default password (`admin123`) before real use.
- [ ] Never paste the Supabase service role key anywhere except the relay script.
- [ ] Tokens are random 32-char strings — don't reuse between sites/systems.
- [ ] The panel login is public; use a strong admin password (and ideally replace the plain-check with a hashed one for production).
- [ ] Keep `setup_tables.sql`, `run-relay.ps1` (contains the mega key) and the APK source private — the APK contains your relay URL and APP token.
- [ ] If you upload this project anywhere public (GitHub), **remove** credentials first: `local.properties`, `run-relay.ps1`, tokens + URL in `SecurityContext.java`, and any keys in `config.php`.
- [ ] The app requests device-admin-level access on install — install it only on devices you own or have explicit permission to test on.

---

## Quick-start cheat sheet (1 line each)

```powershell
# relay
npm install && .\run-relay.ps1
Invoke-WebRequest http://localhost:10000/health

# panel
php -S localhost:8080

# tunnels (two windows)
C:\cloudflared\cloudflared.exe tunnel --url http://localhost:10000
C:\cloudflared\cloudflared.exe tunnel --url http://localhost:8080

# build APK
& "C:\Users\<you>\Gradle\gradle-9.5.1\bin\gradle.bat" assembleDebug
# → app\build\outputs\apk\debug\app-debug.apk
```
