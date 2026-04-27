# SIPKPFI Automation Testing dengan Cypress

Automation testing untuk sistem SIPKPFI menggunakan Cypress untuk mengetest flow login dan pengajuan pinjaman.

> 🚀 **Ingin langsung mulai?** Lihat [QUICK_START.md](QUICK_START.md) untuk panduan cepat!

## 📋 Prasyarat

Pastikan sudah terinstall:
- Node.js (v14 atau lebih tinggi)
- NPM atau Yarn
- Application SIPKPFI berjalan di `http://sipkpfi.test`

## 🚀 Instalasi

1. Masuk ke direktori automation_test:
```bash
cd automation_test
```

2. Install dependencies:
```bash
npm install
```

atau jika menggunakan yarn:
```bash
yarn install
```

## ⚙️ Konfigurasi

File konfigurasi utama ada di `cypress.config.js`:

```javascript
{
  baseUrl: 'http://sipkpfi.test',
  viewportWidth: 1280,
  viewportHeight: 720
}
```

### Credentials Test

Credentials untuk testing sudah dikonfigurasi di:
- **File**: `cypress/fixtures/loanApplication.json`
- **Email**: `admin@example.com`
- **Password**: `your_password`

## 🧪 Menjalankan Test

### Mode Interactive (Cypress Test Runner)

Untuk membuka Cypress Test Runner dengan UI interaktif:

```bash
npx cypress open
```

Pilih test yang ingin dijalankan:
- `login.cy.js` - Test login dan dashboard
- `loanApplication.cy.js` - Test alur pengajuan pinjaman

### Mode Headless (Command Line)

Untuk menjalankan semua test secara otomatis:

```bash
npx cypress run
```

Menjalankan test spesifik:

```bash
# Test login saja
npx cypress run --spec "cypress/e2e/login.cy.js"

# Test loan application saja
npx cypress run --spec "cypress/e2e/loanApplication.cy.js"
```

### Menjalankan dengan Browser Spesifik

```bash
# Chrome
npx cypress run --browser chrome

# Firefox
npx cypress run --browser firefox

# Edge
npx cypress run --browser edge
```

### Menjalankan dengan Report Generation

Untuk menjalankan test dan generate HTML report:

```bash
npm run test:report
```

Script ini akan:
1. Menjalankan semua test
2. Generate video recording untuk setiap test
3. Merge semua JSON reports
4. Generate HTML report yang interaktif

Untuk membersihkan semua reports sebelum test:

```bash
npm run clean:reports
```

## 📊 Test Reports & Video Recording

### Video Recording

Setiap kali test dijalankan (mode headless), Cypress akan otomatis merecord video:

- **Lokasi**: `cypress/videos/`
- **Format**: MP4
- **Kompresi**: Level 32 (balance antara quality dan file size)
- **Status**:
  - ✅ Video tetap disimpan meskipun test berhasil
  - ✅ Video disimpan untuk semua test

**Contoh file video:**
```
cypress/videos/
├── login.cy.js.mp4
└── loanApplication.cy.js.mp4
```

### HTML Report (Mochawesome)

Test report dalam format HTML interaktif yang mencakup:

- ✅ **Test Summary**: Total test, passed, failed, skipped
- ✅ **Charts**: Visualisasi hasil test dalam pie chart dan bar chart
- ✅ **Detailed Results**: Hasil detail setiap test case
- ✅ **Screenshots**: Embedded screenshots untuk failed tests
- ✅ **Duration**: Waktu eksekusi setiap test
- ✅ **Timeline**: Urutan eksekusi test

**Lokasi Reports:**
```
cypress/reports/
├── *.json                    # Individual test JSON reports
├── merged-report.json        # Merged JSON report
└── html/
    └── report.html          # HTML report (buka di browser)
```

**Membuka HTML Report:**

```bash
# Linux/Mac
npm run report:open

# Windows - manual
# Buka file: cypress/reports/html/report.html di browser
```

### Screenshots

Screenshot otomatis diambil saat:
- ❌ Test gagal (automatically)
- 📸 Command `cy.screenshot()` dipanggil (manually)

**Lokasi**: `cypress/screenshots/`

**Struktur:**
```
cypress/screenshots/
├── login.cy.js/
│   └── should login successfully -- failed.png
└── loanApplication.cy.js/
    └── should submit to verification -- failed.png
```

## 📝 Test Suite Overview

### 1. Login Flow (`login.cy.js`)

Test yang mencakup:
- ✅ Display login page correctly
- ✅ Validation error untuk credentials kosong
- ✅ Error untuk invalid credentials
- ✅ Login successful dengan valid credentials
- ✅ Redirect ke home jika sudah authenticated
- ✅ Handle 404 error pada login
- ✅ Logout successfully
- ✅ Maintain session setelah page refresh

### 2. Loan Application Flow (`loanApplication.cy.js`)

Test yang mencakup:

#### Create and Save Application
- ✅ Navigate ke halaman pengajuan
- ✅ Fill dan save form pengajuan
- ✅ Verify data tersimpan di list

#### Edit Application
- ✅ Open edit form
- ✅ Update dan save perubahan

#### Submit to Verification
- ✅ Show tombol "Ajukan ke Verifikasi" untuk aplikasi yang belum disubmit
- ✅ Submit application ke proses verifikasi
- ✅ Verify data masuk ke verification queue
- ✅ Tidak show tombol submit untuk aplikasi yang sudah disubmit

#### Complete Workflow
- ✅ Full workflow: Create → Save → Edit → Submit

### 3. Full Flow - Simulation to Reporting (`fullFlow.cy.js`) ⭐ NEW!

Test comprehensive yang mencakup seluruh alur workflow dari simulasi sampai reporting dengan berbagai user role.

#### 🔄 Complete Workflow (8 Steps)

```
Simulation → Application → SLIK Verification → Financing Verification
    ↓
Approval → Disbursement → Monitoring → Reporting
```

#### 👥 User Roles

Test menggunakan 4 role berbeda:
- **Admin** - Create simulation, application, monitoring, reporting
- **Verifikasi** - Verify SLIK and financing documents
- **Approval** - Approve/reject applications
- **Bank** - Process disbursement

#### 📋 Test Coverage

**Step 1: Simulation**
- ✅ Login as Admin
- ✅ Create loan simulation
- ✅ Verify simulation data

**Step 2: Application Creation**
- ✅ Create complete loan application
- ✅ Fill all 4 tabs (Personal, Pension, Product, Service)
- ✅ Submit to verification queue

**Step 3: SLIK Verification**
- ✅ Login as Verifikasi role
- ✅ Access SLIK verification queue
- ✅ Approve SLIK document

**Step 4: Financing Verification**
- ✅ Access financing verification queue
- ✅ Approve financing application

**Step 5: Approval**
- ✅ Login as Approval role
- ✅ Access approval queue
- ✅ Approve application

**Step 6: Operational/Disbursement**
- ✅ Login as Bank role
- ✅ Access disbursement queue
- ✅ Verify operational access

**Step 7: Monitoring**
- ✅ Access monitoring page
- ✅ Verify approved applications

**Step 8: Reporting**
- ✅ Access all report pages
- ✅ Verify reports accessible:
  - Daftar Nominatif
  - Arus Kas
  - Outstanding Aktif
  - Laporan Bulanan

#### 📖 Documentation

Untuk dokumentasi lengkap full flow test, lihat: **[FULL_FLOW_TEST.md](FULL_FLOW_TEST.md)**

#### 🚀 Running Full Flow Test

```bash
# Run full flow test only
npx cypress run --spec "cypress/e2e/fullFlow.cy.js"

# Run in interactive mode
npx cypress open
# Then select fullFlow.cy.js
```

## 📂 Struktur File

```
automation_test/
├── cypress/
│   ├── e2e/
│   │   ├── login.cy.js              # Test login flow
│   │   ├── loanApplication.cy.js    # Test loan application flow
│   │   └── fullFlow.cy.js           # ⭐ Test full flow (simulation to reporting)
│   ├── fixtures/
│   │   ├── loanApplication.json     # Test data untuk loan application
│   │   └── fullFlow.json            # ⭐ Test data untuk full flow
│   ├── support/
│   │   ├── commands.js              # Custom Cypress commands (updated with full flow commands)
│   │   └── e2e.js                   # Support file & reporter config
│   ├── videos/                      # Video recordings (auto-generated)
│   ├── screenshots/                 # Screenshots on failure (auto-generated)
│   └── reports/                     # Test reports (auto-generated)
│       ├── *.json                   # Individual JSON reports
│       ├── merged-report.json       # Merged JSON report
│       └── html/
│           └── report.html          # Interactive HTML report
├── cypress.config.js                # Cypress configuration
├── package.json                     # NPM dependencies & scripts
├── .gitignore                       # Git ignore patterns
├── README.md                        # File ini
├── FULL_FLOW_TEST.md               # ⭐ Dokumentasi full flow test
└── QUICK_START.md                   # Quick start guide
```

## 🛠️ Custom Commands

Custom commands yang tersedia di `cypress/support/commands.js`:

### Basic Commands

#### `cy.login(email, password)`
Login ke aplikasi dengan credentials yang diberikan.

**Fitur:**
- Otomatis clear cookies dan localStorage sebelum login
- Mencegah konflik session dari login sebelumnya
- Memastikan clean state untuk setiap login

```javascript
cy.login('admin@example.com', 'your_password')
```

#### `cy.logout()`
Logout dari aplikasi.

```javascript
cy.logout()
```

#### `cy.waitForPageLoad()`
Menunggu halaman selesai loading.

```javascript
cy.waitForPageLoad()
```

#### `cy.checkNotification(type, message)`
Mengecek notifikasi sukses/error.

```javascript
cy.checkNotification('success', 'Data Berhasil disimpan')
```

### Loan Application Commands

#### `cy.fillLoanApplicationForm(applicationData)`
Mengisi form aplikasi pembiayaan lengkap (semua tab).

```javascript
cy.fillLoanApplicationForm(applicationData)
```

#### `cy.clickEditButton(rowIndex)`
Klik tombol edit pada tabel.

```javascript
cy.clickEditButton(0) // Edit row pertama
```

### Full Flow Commands ⭐ NEW!

#### `cy.fillSimulationForm(simulationData)`
Mengisi form simulasi pembiayaan.

```javascript
cy.fillSimulationForm({
  birth_date: '01-01-1959',
  salary: '8000000',
  plafon: '50000000',
  tenor: '24'
})
```

#### `cy.approveRejectApplication(action, notes)`
Approve atau reject aplikasi.

```javascript
cy.approveRejectApplication('approve', 'Application approved')
cy.approveRejectApplication('reject', 'Missing documents')
```

#### `cy.navigateToSidebarMenu(mainMenu, subMenu)`
Navigate ke menu di sidebar.

```javascript
cy.navigateToSidebarMenu('Pengajuan', 'Verifikasi SLIK')
```

#### `cy.checkApplicationInTable(searchText)`
Cek apakah aplikasi ada di tabel.

```javascript
cy.checkApplicationInTable('Budi Santoso')
```

#### `cy.clickDetailButton(rowIndex)`
Klik tombol detail pada tabel.

```javascript
cy.clickDetailButton(0) // Detail row pertama
```

#### `cy.submitToVerification(rowIndex)`
Submit aplikasi ke verifikasi.

```javascript
cy.submitToVerification(0)
```

#### `cy.waitForDataTable()`
Menunggu DataTable selesai loading.

```javascript
cy.waitForDataTable()
```

#### `cy.uploadFileToInput(inputName, filePath)`
Upload file ke input.

```javascript
cy.uploadFileToInput('interview_video', 'cypress/video.mp4')
```

#### `cy.generateReport(startDate, endDate)`
Generate report dengan date range.

```javascript
cy.generateReport('01-01-2024', '31-12-2024')
```

## ✅ Checklist Perbaikan yang Ditest

Test ini memverifikasi perbaikan yang telah dilakukan:

1. **✅ Login 404 Issue**
   - Test memverifikasi tidak ada error 404 setelah login
   - Dashboard load dengan benar

2. **✅ Alur Save/Submit Terpisah**
   - Data disimpan tanpa langsung masuk verifikasi (`is_confirm = false`)
   - Tombol "Ajukan ke Verifikasi" muncul untuk data yang belum disubmit
   - Data masuk verifikasi hanya setelah klik submit

3. **✅ Workflow Lengkap**
   - Admin Input (Save) → Data tersimpan
   - Edit data multiple kali
   - Submit → Data masuk verifikasi
   - Verifikasi → Slik → Approval → Akad → Pencairan

## 🔧 Troubleshooting

### Test Gagal karena Timeout

Increase timeout di `cypress.config.js`:
```javascript
defaultCommandTimeout: 15000,
pageLoadTimeout: 60000
```

### Element Tidak Ditemukan

Pastikan selector di test sesuai dengan HTML aplikasi:
```javascript
// Gunakan cy.get() dengan timeout
cy.get('#elementId', { timeout: 10000 })
```

### Database State

Pastikan database dalam kondisi clean sebelum test:
- Hapus data test sebelumnya
- Atau gunakan data yang sudah ada di database

## 🎬 Menggunakan Video dan Reports untuk Debugging

### Workflow Debugging dengan Video

1. **Jalankan Test:**
   ```bash
   npm test
   ```

2. **Check Terminal Output:**
   - Lihat test mana yang gagal
   - Note nama test yang fail

3. **Buka Video Recording:**
   - Navigasi ke `cypress/videos/`
   - Buka file `.mp4` yang sesuai dengan test yang gagal
   - Watch step-by-step apa yang terjadi

4. **Check Screenshots (jika test gagal):**
   - Navigasi ke `cypress/screenshots/`
   - Lihat screenshot exact moment test gagal

5. **Buka HTML Report:**
   ```bash
   # Setelah run test dengan npm run test:report
   # Buka cypress/reports/html/report.html di browser
   ```

   Di HTML report Anda bisa lihat:
   - ✅ Timeline lengkap eksekusi test
   - ✅ Duration setiap test case
   - ✅ Error messages yang detail
   - ✅ Screenshot embedded langsung di report

### Tips Video Recording

**Mematikan Video untuk Test Lokal:**

Jika ingin run test tanpa video (lebih cepat):

Edit `cypress.config.js`:
```javascript
video: false  // Default: true
```

**Video Quality vs File Size:**

Adjust compression level di `cypress.config.js`:
```javascript
videoCompression: 32  // 0-51 (0=no compression, 51=max compression)
```

Recommendation:
- Development: `videoCompression: 40` (smaller files, faster)
- CI/CD: `videoCompression: 32` (balance)
- Documentation: `videoCompression: 15` (high quality)

### Contoh Output Setelah Test Run

```
cypress/
├── videos/
│   ├── login.cy.js.mp4                    (2.3 MB, 45s)
│   └── loanApplication.cy.js.mp4          (4.1 MB, 1m 23s)
├── screenshots/
│   └── loanApplication.cy.js/
│       └── should submit -- failed.png    (123 KB)
└── reports/
    ├── login.json
    ├── loanApplication.json
    ├── merged-report.json
    └── html/
        ├── report.html                     <- Buka ini di browser
        ├── assets/
        └── ...
```

### CI/CD Integration

Untuk CI/CD (GitHub Actions, GitLab CI, Jenkins), tambahkan artifact upload:

**GitHub Actions Example:**
```yaml
- name: Run Cypress Tests
  run: npm run test:report

- name: Upload Test Artifacts
  if: always()
  uses: actions/upload-artifact@v3
  with:
    name: cypress-results
    path: |
      cypress/videos/**/*.mp4
      cypress/screenshots/**/*.png
      cypress/reports/html/
    retention-days: 7
```

## 📞 Support

Jika ada issue atau pertanyaan:
1. Check error message di Cypress Test Runner
2. **Check video recording** di `cypress/videos/`
3. **Check screenshots** di `cypress/screenshots/`
4. **Check HTML report** di `cypress/reports/html/report.html`
5. Verify aplikasi berjalan di `http://sipkpfi.test`

## 📖 Dokumentasi

- [Cypress Documentation](https://docs.cypress.io)
- [Best Practices](https://docs.cypress.io/guides/references/best-practices)
- [Custom Commands](https://docs.cypress.io/api/cypress-api/custom-commands)
- [Mochawesome Reporter](https://github.com/adamgruber/mochawesome)
- [Video Recording](https://docs.cypress.io/guides/guides/screenshots-and-videos)

---

**Last Updated**: January 2026
**Version**: 1.1.0 (Added Video & HTML Report Generation)
