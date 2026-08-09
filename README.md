<p align="center">
  <img src="https://raw.githubusercontent.com/cmdhell/Tesvrix/refs/heads/main/logo2_dty1yw.png" alt="Tesvrix Logo" width="220">
</p><p align="center">
  <img src="https://raw.githubusercontent.com/cmdhell/Tesvrix/refs/heads/main/IMG_20260806_130805_435.jpg" alt="Tesvrix Preview" width="900">
</p><h1 align="center">Tesvrix — Complete Local Setup Guide</h1><p align="center">
  <b>PHP Web Panel • Node.js Backend • Supabase • Android Test Client</b>
</p><p align="center">
  <i>Development, testing and authorized device-management environment</i>
</p>---

📖 About

This README explains how to set up the Tesvrix development environment on a Windows PC from scratch.

It covers:

- Installing the required software
- Creating the Supabase database
- Configuring the Node.js backend
- Running the PHP web panel
- Connecting the components locally
- Optional Cloudflare development tunnels
- Preparing the Android test client
- Building a debug APK
- Installing and testing the APK
- Troubleshooting common problems
- Secure configuration
- GitHub publishing
- Optional startup automation

«Important: Tesvrix should only be used on systems and devices that you own or have explicit permission to administer. Android testing should be performed using an emulator, dedicated test device, or another device whose owner has explicitly authorized the testing.»

---

🧩 Project Structure

Tesvrix/
│
├── README.md
├── LICENSE
├── .gitignore
│
├── index.php
├── dashboard.php
├── project.js
│
├── config/
│   └── config.php
│
├── section/
│   ├── CALL COMMAND.php
│   ├── DEVICE STATS.php
│   ├── SECURITY.php
│   ├── SMS CENTER.php
│   ├── about.php
│   ├── cam.php
│   ├── coming.php
│   ├── file.php
│   ├── intercom.php
│   ├── keys.php
│   ├── location.php
│   ├── notifications.php
│   ├── screen.php
│   └── surveillance.php
│
├── Server/
│   ├── index.js
│   ├── package.json
│   └── ...
│
├── Android/
│   ├── app/
│   ├── build.gradle
│   ├── settings.gradle
│   └── gradlew.bat
│
└── database/
    └── setup_tables.sql

«File names shown above reflect the current project layout. Rename files to conventional lowercase names if you want a cleaner cross-platform repository.»

---

🏗️ How Tesvrix Works

The development architecture contains four major components:

                         INTERNET
                            │
                            │ HTTPS
                            ▼
                 ┌─────────────────────┐
                 │ Optional Cloudflare │
                 │      Tunnel         │
                 └──────────┬──────────┘
                            │
              ┌─────────────┴─────────────┐
              │                           │
              ▼                           ▼
     ┌─────────────────┐         ┌─────────────────┐
     │   PHP WEB PANEL │         │  NODE.JS SERVER │
     │   Port 8080     │────────►│   Port 10000    │
     └─────────────────┘         └────────┬────────┘
                                         │
                                         │ API
                                         ▼
                                ┌─────────────────┐
                                │    SUPABASE     │
                                │   PostgreSQL    │
                                └─────────────────┘

                                         ▲
                                         │
                                ┌────────┴────────┐
                                │ Android Test    │
                                │ Client / Emulator│
                                └─────────────────┘

Components

1. Android Test Client

A development Android application used to test authorized API communication with the backend.

2. Node.js Backend

The server-side application responsible for:

- API requests
- Authentication
- Authorization
- Database communication
- Application logic
- Validation

3. PHP Web Panel

The browser-based dashboard.

It communicates with the backend rather than exposing privileged database credentials to browser JavaScript.

4. Supabase

Provides the PostgreSQL database and associated cloud services.

---

🔐 Security Model

The intended data flow is:

Android / Browser
       │
       │ HTTPS
       ▼
Authentication
       │
       ▼
Node.js API
       │
       │ Server-side credentials
       ▼
Supabase

The browser and Android client should never receive a Supabase service-role credential.

Privileged credentials belong exclusively on the server.

---

📑 Table of Contents

1. "Requirements" (#1-requirements)
2. "Recommended Windows Folder" (#2-recommended-windows-folder)
3. "Install Git" (#3-install-git)
4. "Install Node.js" (#4-install-nodejs)
5. "Install PHP" (#5-install-php)
6. "Install JDK 17" (#6-install-jdk-17)
7. "Install Android Studio" (#7-install-android-studio)
8. "Configure Android SDK" (#8-configure-android-sdk)
9. "Configure Gradle" (#9-configure-gradle)
10. "Clone the Project" (#10-clone-the-project)
11. "Configure Git Ignore" (#11-configure-git-ignore)
12. "Create Supabase Project" (#12-create-supabase-project)
13. "Create Database Tables" (#13-create-database-tables)
14. "Configure Node.js" (#14-configure-nodejs)
15. "Start Node.js Backend" (#15-start-nodejs-backend)
16. "Configure PHP Panel" (#16-configure-php-panel)
17. "Start PHP Panel" (#17-start-php-panel)
18. "Run Local Tests" (#18-run-local-tests)
19. "Prepare Android Test Client" (#19-prepare-android-test-client)
20. "Build Android APK" (#20-build-android-apk)
21. "Install APK Using ADB" (#21-install-apk-using-adb)
22. "Optional Cloudflare Tunnel" (#22-optional-cloudflare-tunnel)
23. "Permanent Cloudflare Configuration" (#23-permanent-cloudflare-configuration)
24. "Automatic Startup" (#24-automatic-startup)
25. "Troubleshooting" (#25-troubleshooting)
26. "Production Security" (#26-production-security)
27. "GitHub Publishing Checklist" (#27-github-publishing-checklist)
28. "Complete Setup Checklist" (#28-complete-setup-checklist)
29. "Quick Start" (#29-quick-start)

---

1. Requirements

Required

Software| Purpose
Windows 10/11| Development PC
Git| Source control
Node.js LTS| Backend
npm| Node package manager
PHP 8.1+| Web panel
JDK 17| Android build
Android Studio| Android development
Android SDK| Android compilation
Platform Tools| ADB/device testing
Gradle| Android build
Supabase| PostgreSQL database

Optional

Software| Purpose
Cloudflare Tunnel| Remote development
VS Code| Code editor
Android Emulator| Testing
Postman| API testing

---

2. Recommended Windows Folder

A simple development layout is:

C:\Tesvrix\
│
├── web\
├── Server\
├── Android\
├── database\
└── tools\

For example:

C:\Tesvrix\web
C:\Tesvrix\Server
C:\Tesvrix\Android
C:\Tesvrix\database
C:\Tesvrix\tools

Optional Cloudflare location:

C:\Tesvrix\tools\cloudflared\

---

3. Install Git

Install Git for Windows.

Verify:

git --version

Configure your identity:

git config --global user.name "Your Name"
git config --global user.email "your@email.com"

---

4. Install Node.js

Install the current Node.js LTS release.

Verify:

node --version
npm --version

Example:

v24.x.x
11.x.x

The exact versions may change over time.

---

5. Install PHP

Install PHP 8.1 or newer.

Verify:

php --version

If PowerShell reports:

php is not recognized

add the folder containing "php.exe" to the Windows "PATH".

Restart PowerShell.

Verify again:

php --version

---

6. Install JDK 17

Install a JDK 17 distribution such as Temurin 17.

Verify:

java -version
javac -version

Both should report version 17.

If required, configure:

JAVA_HOME

Example:

JAVA_HOME=C:\Program Files\Eclipse Adoptium\jdk-17.x.x

Add:

%JAVA_HOME%\bin

to "PATH".

Restart PowerShell.

---

7. Install Android Studio

Install Android Studio.

During installation, install:

Android SDK
Android SDK Platform
Android SDK Platform-Tools
Android SDK Build-Tools
Android Emulator

Open Android Studio once installation finishes.

---

8. Configure Android SDK

Open:

Android Studio
→ Settings
→ Languages & Frameworks
→ Android SDK

Install the Android SDK version required by the project's Gradle configuration.

Under SDK Tools, install:

Android SDK Build-Tools
Android SDK Platform-Tools
Android SDK Command-line Tools

Typical SDK locations are:

C:\Users\<USERNAME>\AppData\Local\Android\Sdk

or:

C:\Android\Sdk

Verify ADB:

adb version

---

9. Configure Gradle

If the Android repository contains:

gradlew
gradlew.bat

use the included Gradle wrapper.

Check:

cd C:\Tesvrix\Android
.\gradlew.bat --version

This is preferred over manually installing a different Gradle version.

The project's Gradle wrapper and Android Gradle Plugin determine the compatible Gradle version.

---

10. Clone the Project

Clone the repository:

cd C:\
git clone <YOUR_REPOSITORY_URL> Tesvrix

Enter the project:

cd C:\Tesvrix

Check:

dir

---

11. Configure Git Ignore

Create:

.gitignore

Recommended contents:

# Environment files
.env
.env.*
!.env.example

# Android local configuration
local.properties

# Android signing
*.jks
*.keystore

# Build output
/build/
/app/build/
*/build/

# IDE
.idea/
*.iml

# Logs
*.log

# OS
.DS_Store
Thumbs.db

# Temporary files
*.tmp
*.temp

# Secrets
secrets/
private/
credentials/

Never commit production secrets.

---

12. Create Supabase Project

Create a Supabase project.

After creation, collect only the credentials required by your backend.

Typical information:

Project URL
Database configuration
Server-side API credential

Keep privileged credentials on the server.

---

13. Create Database Tables

Open:

C:\Tesvrix\database\setup_tables.sql

Open the Supabase SQL Editor.

Paste the SQL and execute it.

Verify that the expected development tables were created.

For example:

devices
commands
settings
operators

Database Security

Do not assume that hiding the database URL provides security.

Use:

Authentication
Authorization
Row Level Security
Least privilege
Input validation
Server-side access control

---

14. Configure Node.js

Open:

C:\Tesvrix\Server

Install dependencies:

npm install

Create:

.env

Example:

PORT=10000

SUPABASE_URL=https://YOUR_PROJECT.supabase.co

SUPABASE_KEY=YOUR_SERVER_SIDE_KEY

WEB_ACCESS_TOKEN=GENERATE_A_RANDOM_VALUE

If your application has an Android API authentication mechanism, configure it through the backend's documented authentication system rather than embedding privileged credentials in the APK.

Generate a random development secret

PowerShell:

[Convert]::ToHexString(
    [Security.Cryptography.RandomNumberGenerator]::GetBytes(32)
)

Generate separate secrets for separate purposes.

---

15. Start Node.js Backend

Navigate to:

cd C:\Tesvrix\Server

Start:

npm start

If no "start" script exists:

node index.js

Expected output should indicate that the server is listening.

Example:

Server started
Listening on port 10000

Keep this terminal open.

Health Check

If your project provides "/health":

Invoke-WebRequest http://127.0.0.1:10000/health

A successful result should report that the server is online.

---

16. Configure PHP Panel

Open:

C:\Tesvrix\web\config\config.php

For local development:

<?php

$proxy_url = 'http://127.0.0.1:10000';

If the application requires authentication credentials, load them from an environment variable or local untracked configuration.

Do not commit production credentials to GitHub.

---

17. Start PHP Panel

Open a second PowerShell window:

cd C:\Tesvrix\web

Start the PHP development server:

php -S 127.0.0.1:8080

Open:

http://127.0.0.1:8080

You should now see the web panel.

---

18. Run Local Tests

At this stage:

Node.js
127.0.0.1:10000

and:

PHP
127.0.0.1:8080

should both be running.

Test Order

Test 1 — PHP

Open:

http://127.0.0.1:8080

Test 2 — Backend

Open the health endpoint:

http://127.0.0.1:10000/health

Test 3 — Database

Verify the backend can communicate with Supabase.

Test 4 — Authentication

Verify:

Unauthenticated → rejected
Authenticated → allowed

Test 5 — Authorization

Verify users can access only the records they are authorized to access.

---

19. Prepare Android Test Client

The Android application should be tested only on an authorized device or emulator.

Recommended:

Android Studio Emulator

or:

Dedicated personal Android test device

The Android application should clearly disclose:

Permissions requested
Data collected
Purpose of collection
Server destination
How to stop the service

Do not hide application activity from the device owner.

---

20. Build Android APK

Enter the Android project:

cd C:\Tesvrix\Android

Check Gradle:

.\gradlew.bat --version

Clean:

.\gradlew.bat clean

Build debug:

.\gradlew.bat assembleDebug

Successful output will normally be located under:

app\build\outputs\apk\debug\

Usually:

app-debug.apk

---

21. Install APK Using ADB

Connect your authorized test phone.

Enable:

Developer Options
USB Debugging

Check the device:

adb devices

Expected:

List of devices attached
XXXXXXXX    device

Install:

adb install -r app\build\outputs\apk\debug\app-debug.apk

If an older version is installed, the "-r" flag updates it.

---

22. Optional Cloudflare Tunnel

For local-only development, skip this section.

If remote development is necessary, Cloudflare Tunnel can expose a local service without opening a router port.

Download "cloudflared" and place it somewhere such as:

C:\Tesvrix\tools\cloudflared\

Test the PHP panel:

cd C:\Tesvrix\tools\cloudflared
.\cloudflared.exe tunnel --url http://127.0.0.1:8080

Cloudflare will provide a temporary HTTPS address.

Example:

https://random-name.trycloudflare.com

⚠️ Important

This makes your local application reachable from the Internet.

Before enabling it:

[ ] Authentication enabled
[ ] Strong password
[ ] No default credentials
[ ] No database secrets exposed
[ ] Authorization enforced
[ ] Sensitive endpoints protected
[ ] Logs enabled

Never expose an unprotected administration interface.

---

23. Permanent Cloudflare Configuration

Quick tunnels are temporary.

For a legitimate long-running development environment, use a named Cloudflare Tunnel and your own domain.

The general architecture is:

your-domain.example
        │
        ▼
Cloudflare
        │
        ▼
Named Tunnel
        │
        ▼
127.0.0.1:8080

The exact Cloudflare configuration depends on your domain and account.

Keep the tunnel configuration private and restrict access to the application itself.

---

24. Automatic Startup

Once the local development system works, you can optionally automate startup.

Start Node.js

Create:

start-server.cmd

Example:

@echo off

cd /d C:\Tesvrix\Server

npm start

pause

Start PHP

Create:

start-panel.cmd

Example:

@echo off

cd /d C:\Tesvrix\web

php -S 127.0.0.1:8080

pause

Run these manually first.

Only configure Windows startup after confirming both applications work correctly.

---

25. Troubleshooting

PHP is not recognized

Run:

php --version

If it fails, add PHP to "PATH".

Restart PowerShell.

---

Node.js is not recognized

Run:

node --version
npm --version

Reinstall Node.js LTS if required.

---

"npm install" fails

Try:

npm cache verify
npm install

Check:

node --version
npm --version

Also inspect "package.json".

---

Port 10000 already in use

Run:

netstat -ano | findstr :10000

You can either stop the conflicting process or change the application's development port.

---

Port 8080 already in use

Run:

netstat -ano | findstr :8080

Alternatively:

php -S 127.0.0.1:8081

Remember to update the corresponding application configuration.

---

Supabase connection fails

Check:

Supabase URL
Server-side credentials
Environment variables
Network connectivity
Database permissions
RLS policies

Do not put a privileged key into the APK to solve a server configuration problem.

---

Android build fails

Run:

java -version

Then:

.\gradlew.bat --version

Then:

.\gradlew.bat clean

Try again:

.\gradlew.bat assembleDebug

Check:

JDK
Android SDK
Build Tools
Gradle wrapper
Android Gradle Plugin
compileSdk

---

"sdk.dir" error

Create:

C:\Tesvrix\Android\local.properties

Example:

sdk.dir=C:\\Users\\YOUR_USERNAME\\AppData\\Local\\Android\\Sdk

Do not commit this file.

---

ADB cannot find the phone

Run:

adb devices

Then:

1. Enable Developer Options
2. Enable USB Debugging
3. Unlock the phone
4. Reconnect USB
5. Accept the debugging authorization prompt
6. Run adb devices again

---

26. Production Security

The PHP built-in server is intended for development.

Do not treat:

php -S 127.0.0.1:8080

as a production hosting solution.

For production, use an appropriate web server and proper deployment architecture.

Minimum Requirements

HTTPS / TLS
Strong authentication
Server-side authorization
Secure sessions
CSRF protection
Input validation
Output encoding
Rate limiting
Database access controls
Row Level Security
Secure cookies
Secret management
Logging
Backups
Dependency updates

---

🔑 Secrets

Never commit:

.env
local.properties
*.jks
*.keystore
*.pem
private keys
database passwords
service-role keys
production API keys
authentication secrets

If a secret is accidentally pushed to GitHub:

1. Revoke it immediately
2. Generate a new secret
3. Replace it locally
4. Remove the old secret from repository history
5. Check logs for unauthorized use

Simply deleting a secret from the latest commit is not enough.

---

27. GitHub Publishing Checklist

Before pushing:

git status

Review all files.

Search for sensitive values such as:

password
secret
token
apikey
service_role
private_key

Check ignored files:

git status --ignored

Then:

git add .
git commit -m "Prepare development release"
git push

---

28. Complete Setup Checklist

Windows

[ ] Windows ready
[ ] Git installed
[ ] Node.js installed
[ ] npm working
[ ] PHP installed
[ ] JDK 17 installed
[ ] Android Studio installed
[ ] Android SDK installed
[ ] Platform Tools installed
[ ] ADB working

Project

[ ] Repository cloned
[ ] Folder structure verified
[ ] .gitignore configured
[ ] Environment configuration created

Supabase

[ ] Project created
[ ] Database created
[ ] SQL imported
[ ] Tables verified
[ ] Authentication configured
[ ] Authorization configured
[ ] RLS reviewed

Node.js

[ ] npm install completed
[ ] Environment variables configured
[ ] Backend starts
[ ] Health check works
[ ] Database connection works

PHP

[ ] config.php configured
[ ] PHP server starts
[ ] Dashboard opens
[ ] Backend communication works

Android

[ ] Android project opens
[ ] Gradle wrapper works
[ ] SDK detected
[ ] Debug APK builds
[ ] ADB detects test device
[ ] APK installs

Remote Development

[ ] Local system tested first
[ ] Authentication enabled
[ ] Authorization enabled
[ ] HTTPS enabled
[ ] Cloudflare configured
[ ] No secrets exposed

---

29. Quick Start

After completing the initial configuration, use three terminals.

Terminal 1 — Node.js

cd C:\Tesvrix\Server
npm install
npm start

---

Terminal 2 — PHP

cd C:\Tesvrix\web
php -S 127.0.0.1:8080

---

Terminal 3 — Android

cd C:\Tesvrix\Android
.\gradlew.bat clean
.\gradlew.bat assembleDebug

---

🌐 Open the Web Panel

http://127.0.0.1:8080

---

📦 Android APK

After a successful build:

C:\Tesvrix\Android\app\build\outputs\apk\debug\app-debug.apk

Install on your authorized test device:

adb install -r .\app\build\outputs\apk\debug\app-debug.apk

---

🧪 Recommended Development Order

Always follow this order:

1. Install Windows dependencies
             ↓
2. Configure Git
             ↓
3. Configure Node.js
             ↓
4. Configure PHP
             ↓
5. Configure JDK
             ↓
6. Configure Android SDK
             ↓
7. Clone Tesvrix
             ↓
8. Configure .gitignore
             ↓
9. Create Supabase project
             ↓
10. Import database schema
             ↓
11. Configure server environment
             ↓
12. Start Node.js backend
             ↓
13. Start PHP panel
             ↓
14. Test everything locally
             ↓
15. Prepare Android test client
             ↓
16. Build debug APK
             ↓
17. Test using authorized device/emulator
             ↓
18. Add remote tunnel only if required
             ↓
19. Secure the deployment
             ↓
20. Publish only sanitized source

---

🛡️ Responsible Use

Tesvrix should only be used in environments where you have explicit authorization.

Use:

Your own PC
Your own database
Your own test devices
Android Emulator
Authorized test accounts
Authorized networks

Do not use the project to:

✗ secretly monitor people
✗ secretly collect private information
✗ access another person's messages
✗ access cameras or microphones without consent
✗ track unauthorized devices
✗ bypass Android security
✗ hide unauthorized device activity
✗ deploy unauthorized remote-control functionality

---

⭐ Development Principles

SECURE BY DEFAULT
       +
EXPLICIT CONSENT
       +
LEAST PRIVILEGE
       +
SERVER-SIDE AUTHORIZATION
       +
NO HARDCODED SECRETS
       +
LOCAL-FIRST TESTING
       +
CLEAR DOCUMENTATION

---

📄 License

Add the project's actual license here.

Example:

Copyright © 2026 Tesvrix

See LICENSE for complete license terms.

---

🚀 Tesvrix

Local development.
Controlled testing.
Secure architecture.
Explicit authorization.
