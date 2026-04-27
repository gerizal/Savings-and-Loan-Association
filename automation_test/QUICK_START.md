# 🚀 Quick Start Guide - SIPKPFI Automation Test

Panduan cepat untuk menjalankan automation test dengan video recording dan HTML report.

## ⚡ Setup (First Time Only)

### 1. Install Dependencies

```bash
cd automation_test
npm install
```

Dependencies yang akan terinstall:
- ✅ Cypress (testing framework)
- ✅ Mochawesome Reporter (HTML reports)
- ✅ Report merge tools

**Estimasi waktu:** 2-3 menit

---

## 🎯 Menjalankan Test

### Option 1: Quick Test (Tanpa Report)

Paling cepat untuk development & debugging:

```bash
npm test
```

**Output:**
- ✅ Video recordings di `cypress/videos/`
- ✅ Screenshots (jika ada failure) di `cypress/screenshots/`
- ✅ Terminal output

---

### Option 2: Full Test + HTML Report (Recommended)

Untuk test lengkap dengan interactive HTML report:

```bash
npm run test:report
```

**Output:**
- ✅ Video recordings di `cypress/videos/`
- ✅ Screenshots (jika ada failure) di `cypress/screenshots/`
- ✅ HTML Report di `cypress/reports/html/report.html`
- ✅ JSON reports di `cypress/reports/`

**Estimasi waktu:** 2-5 menit (tergantung jumlah test)

---

### Option 3: Interactive Mode (UI)

Untuk development & debugging dengan Cypress UI:

```bash
npm run cy:open
```

Kemudian:
1. Pilih browser (Chrome, Firefox, Edge)
2. Klik test file yang ingin dijalankan
3. Watch test run secara real-time

**Note:** Interactive mode TIDAK generate video recording.

---

## 📊 Melihat Test Results

### 1. Video Recording

Setelah test selesai:

```bash
cd cypress/videos
```

Buka file `.mp4` dengan video player:
- 🎬 `login.cy.js.mp4` - Recording test login
- 🎬 `loanApplication.cy.js.mp4` - Recording test pengajuan

**Tips:**
- Double click video untuk play
- Video menunjukkan step-by-step apa yang terjadi during test
- Gunakan untuk debug test yang gagal

---

### 2. HTML Report

Setelah run `npm run test:report`:

**Windows:**
```bash
# Manual: Buka file di File Explorer
explorer cypress/reports/html/report.html
```

**Linux/Mac:**
```bash
npm run report:open
```

**HTML Report berisi:**
- 📊 Summary: Total pass/fail tests
- 📈 Charts: Pie chart & bar chart visualisasi
- 📝 Detailed results: Setiap test case dengan duration
- 📸 Screenshots: Embedded untuk failed tests
- ⏱️ Timeline: Urutan eksekusi test

---

### 3. Screenshots (Failed Tests Only)

Jika ada test yang gagal:

```bash
cd cypress/screenshots
```

Screenshot diorganisir per test file:
```
screenshots/
├── login.cy.js/
│   └── should login successfully -- failed.png
└── loanApplication.cy.js/
    └── should submit to verification -- failed.png
```

---

## 🔄 Workflow: Development & Testing

### Scenario 1: Quick Check (Development)

```bash
# 1. Run test
npm test

# 2. Check terminal - apakah pass/fail?

# 3. Jika ada yang fail, buka video
cd cypress/videos
# Double click file .mp4

# 4. Fix code berdasarkan video

# 5. Re-run test
npm test
```

---

### Scenario 2: Full Report (Before Commit/PR)

```bash
# 1. Clean old reports
npm run clean:reports

# 2. Run test dengan full report
npm run test:report

# 3. Buka HTML report
# Windows: explorer cypress/reports/html/report.html
# Linux/Mac: npm run report:open

# 4. Verify semua test passed

# 5. Commit code + push
```

---

### Scenario 3: Test Specific Feature

```bash
# Test login only
npm run test:login

# Test loan application only
npm run test:loan

# Test dengan browser spesifik
npm run test:chrome
npm run test:firefox
```

---

## 🐛 Debugging Failed Tests

### Step 1: Identifikasi Test yang Gagal

Check terminal output:
```
  ✓ should display login page correctly (1234ms)
  ✗ should login successfully (2345ms)
  ✓ should logout successfully (987ms)
```

### Step 2: Watch Video Recording

1. Buka `cypress/videos/login.cy.js.mp4`
2. Watch frame-by-frame apa yang terjadi
3. Identify exact moment test gagal

### Step 3: Check Screenshot

1. Buka `cypress/screenshots/login.cy.js/`
2. Lihat screenshot saat test gagal
3. Analyze element state, error messages, dll

### Step 4: Check HTML Report

1. Buka `cypress/reports/html/report.html`
2. Find failed test
3. Read error message & stack trace
4. Check embedded screenshot

### Step 5: Fix & Re-test

1. Fix code berdasarkan findings
2. Re-run test:
   ```bash
   npm run test:login
   ```
3. Verify test sekarang passing

---

## 📦 Test Outputs Summary

Setelah run test, folder structure:

```
automation_test/
├── cypress/
│   ├── videos/                           # ← VIDEO RECORDINGS
│   │   ├── login.cy.js.mp4              (2.3 MB)
│   │   └── loanApplication.cy.js.mp4    (4.1 MB)
│   │
│   ├── screenshots/                      # ← SCREENSHOTS (jika ada failure)
│   │   └── loanApplication.cy.js/
│   │       └── should submit -- failed.png
│   │
│   └── reports/                          # ← HTML REPORTS
│       ├── login.json
│       ├── loanApplication.json
│       ├── merged-report.json
│       └── html/
│           └── report.html              # ← BUKA INI!
```

---

## 💡 Tips & Best Practices

### 1. Clean Reports Before Important Runs

```bash
npm run clean:reports && npm run test:report
```

### 2. Video File Size

Videos bisa jadi besar. Default compression: 32

Untuk development (faster, smaller):
```javascript
// cypress.config.js
videoCompression: 40
```

### 3. Disable Video untuk Speed

Jika tidak perlu video:
```javascript
// cypress.config.js
video: false
```

### 4. Keep Videos Organized

Delete old videos secara berkala:
```bash
rm -rf cypress/videos/*
```

---

## ❓ Common Issues

### Issue: Test fail dengan "element not found"

**Solution:**
1. Watch video - element muncul di UI?
2. Check selector di test code
3. Add wait time: `cy.wait(1000)`
4. Use `cy.get('#id', { timeout: 10000 })`

### Issue: Video file terlalu besar

**Solution:**
Increase compression di `cypress.config.js`:
```javascript
videoCompression: 40  // atau lebih tinggi
```

### Issue: HTML report tidak generate

**Solution:**
```bash
# Manual generate
npm run report:merge
npm run report:generate
```

### Issue: Application tidak running

**Solution:**
1. Verify `http://sipkpfi.test` accessible
2. Check aplikasi running di background
3. Check database connection

---

## 📞 Need Help?

1. ✅ Check video recording - visual debugging!
2. ✅ Check HTML report - detailed error messages
3. ✅ Check screenshots - UI state saat error
4. ✅ Read full [README.md](README.md) untuk detail
5. ✅ Check terminal output untuk stack trace

---

## 🎓 Next Steps

1. **Sekarang:** Run `npm run test:report`
2. **Buka:** `cypress/reports/html/report.html`
3. **Watch:** Videos di `cypress/videos/`
4. **Understand:** Flow dari video & report
5. **Customize:** Tambah test cases sesuai kebutuhan

Happy Testing! 🚀
