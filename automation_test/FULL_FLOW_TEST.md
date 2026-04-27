# Full Flow Automation Test Documentation

## Overview

Full Flow Automation Test adalah test suite yang comprehensive untuk mengecek alur lengkap aplikasi SIPKPFI dari simulasi pembiayaan sampai reporting. Test ini menggunakan berbagai user role untuk memastikan semua tahapan workflow berjalan dengan benar.

## Test Flow

Test ini mencakup 8 tahapan utama:

```
1. Simulation (Admin)
   ↓
2. Application Creation & Submission (Admin)
   ↓
3. SLIK Verification (Verifikasi)
   ↓
4. Financing Verification (Verifikasi)
   ↓
5. Approval (Approval)
   ↓
6. Operational/Disbursement (Bank)
   ↓
7. Monitoring (Admin)
   ↓
8. Reporting (Admin)
```

## User Roles

Test ini menggunakan 4 user role yang berbeda:

| Role | Email | Password | Responsibilities |
|------|-------|----------|------------------|
| **Admin** | admin@example.com | your_password | Create application, simulation, monitoring, reporting |
| **Verifikasi** | verifikasi@mailinator.com | your_password | Verify SLIK and financing documents |
| **Approval** | approval@mailinator.com | your_password | Approve/reject applications |
| **Bank** | bank@mailinator.com | your_password | Process disbursement |

## Test Structure

### File Structure

```
automation_test/
├── cypress/
│   ├── e2e/
│   │   ├── login.cy.js              # Login flow tests
│   │   ├── loanApplication.cy.js    # Loan application tests
│   │   └── fullFlow.cy.js           # ⭐ Full flow tests
│   ├── fixtures/
│   │   ├── loanApplication.json     # Loan application test data
│   │   └── fullFlow.json            # ⭐ Full flow test data
│   └── support/
│       └── commands.js              # Custom commands (updated)
├── cypress.config.js
└── FULL_FLOW_TEST.md               # This documentation
```

### Test Suites

#### 1. Step 1: Simulation
- Login as Admin
- Navigate to simulation page
- Create new simulation with test data
- Verify simulation appears in list

#### 2. Step 2: Create and Submit Application
- Navigate to loan application page
- Create new loan application
- Fill complete application form (4 tabs)
- Submit application to verification queue

#### 3. Step 3: SLIK Verification
- Login as Verifikasi role
- Navigate to SLIK verification page
- Verify application in queue
- Approve SLIK verification

#### 4. Step 4: Financing Verification
- Navigate to financing verification page
- Verify application in queue
- Approve financing verification

#### 5. Step 5: Approval
- Login as Approval role
- Navigate to approval page
- Verify application in queue
- Approve application

#### 6. Step 6: Operational/Disbursement
- Login as Bank role
- Navigate to operational page
- Check disbursement queue
- (Process disbursement - if accessible)

#### 7. Step 7: Monitoring
- Login as Admin
- Navigate to monitoring page
- Verify approved applications visible

#### 8. Step 8: Reporting
- Navigate to various report pages:
  - Daftar Nominatif
  - Arus Kas
  - Daftar Outstanding Aktif
  - Laporan Bulanan
- Verify all reports are accessible

## Custom Commands

Test ini menggunakan custom commands yang dapat digunakan ulang:

### Existing Commands
- `cy.login(email, password)` - Login dengan credentials (otomatis clear session sebelum login)
- `cy.logout()` - Logout
- `cy.waitForPageLoad()` - Wait for page to load
- `cy.fillLoanApplicationForm(data)` - Fill complete loan application form
- `cy.fillPersonalDataTab(personalData, addressData)` - Fill personal data tab
- `cy.fillPensionDataTab(pensionData)` - Fill pension data tab
- `cy.fillProductDataTab(productData)` - Fill product data tab
- `cy.fillServiceUnitTab(serviceData)` - Fill service unit tab
- `cy.clickEditButton(rowIndex)` - Click edit button in table

### New Commands (Full Flow)
- `cy.fillSimulationForm(simulationData)` - Fill simulation form
- `cy.approveRejectApplication(action, notes)` - Approve or reject application
- `cy.navigateToSidebarMenu(mainMenu, subMenu)` - Navigate to sidebar menu
- `cy.checkApplicationInTable(searchText)` - Check if application exists in table
- `cy.clickDetailButton(rowIndex)` - Click detail button in table
- `cy.submitToVerification(rowIndex)` - Submit application to verification
- `cy.waitForDataTable()` - Wait for DataTable to load
- `cy.uploadFileToInput(inputName, filePath)` - Upload file to input
- `cy.hasAccessToMenu(menuName)` - Check if user has access to menu
- `cy.generateReport(startDate, endDate)` - Generate report with date range

## Running Tests

### Prerequisites

1. Ensure the application is running at `http://sipkpfi.test`
2. Database has been seeded with test users
3. All dependencies are installed:
   ```bash
   cd automation_test
   npm install
   ```

### Run All Tests

Run all tests in headless mode:
```bash
cd automation_test
npx cypress run
```

### Run Full Flow Test Only

Run only the full flow test:
```bash
npx cypress run --spec "cypress/e2e/fullFlow.cy.js"
```

### Run in Interactive Mode

Open Cypress UI to run tests interactively:
```bash
npx cypress open
```

Then select `fullFlow.cy.js` from the test list.

### Run Specific Test Suite

Run a specific describe block:
```bash
npx cypress run --spec "cypress/e2e/fullFlow.cy.js" --grep "Step 3"
```

## Test Data Configuration

Test data is stored in `cypress/fixtures/fullFlow.json`:

### User Credentials
```json
{
  "users": {
    "admin": {
      "email": "admin@example.com",
      "password": "your_password",
      "role": "Admin"
    },
    "verifikasi": { ... },
    "approval": { ... },
    "bank": { ... }
  }
}
```

### Application Data
```json
{
  "applicationData": {
    "personalData": { ... },
    "address": { ... },
    "pensionData": { ... },
    "productData": { ... },
    "serviceUnit": { ... }
  }
}
```

To modify test data, edit the `fullFlow.json` file.

## Reports

After running tests, reports are generated in:

- **HTML Report**: `cypress/reports/index.html`
- **Videos**: `cypress/videos/fullFlow.cy.js.mp4`
- **Screenshots** (on failure): `cypress/screenshots/`

Open the HTML report in browser:
```bash
open automation_test/cypress/reports/index.html
```

## Troubleshooting

### Common Issues

#### 1. User not found / Login failed
- Verify users exist in database
- Check credentials in `fullFlow.json`
- Run seeder: `php artisan db:seed`

#### 2. Application not found in queue
- Check if previous step completed successfully
- Verify application status in database
- Check user permissions

#### 3. DataTable not loading
- Increase timeout in test
- Check network requests in browser console
- Verify API endpoints are working

#### 4. File upload fails
- Ensure test files exist in `cypress/` directory
- Check file paths in test
- Verify file upload permissions

### Debug Mode

Run tests with debug output:
```bash
DEBUG=cypress:* npx cypress run --spec "cypress/e2e/fullFlow.cy.js"
```

## CI/CD Integration

### GitHub Actions Example

```yaml
name: Cypress Full Flow Tests

on: [push, pull_request]

jobs:
  cypress-run:
    runs-on: ubuntu-latest
    steps:
      - name: Checkout
        uses: actions/checkout@v3

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'

      - name: Install dependencies
        run: |
          composer install
          cd automation_test && npm install

      - name: Run Cypress tests
        run: |
          php artisan serve &
          cd automation_test
          npx cypress run --spec "cypress/e2e/fullFlow.cy.js"

      - name: Upload test results
        uses: actions/upload-artifact@v3
        if: always()
        with:
          name: cypress-results
          path: automation_test/cypress/reports/
```

## Best Practices

1. **Run tests in order**: Full flow tests should run sequentially as each step depends on the previous one.

2. **Use unique test data**: Generate unique IDs/numbers for each test run to avoid conflicts.

3. **Clean up after tests**: Consider adding cleanup steps to remove test data.

4. **Handle race conditions**: Use proper waits and assertions to handle async operations.

5. **Log important steps**: Use `cy.log()` to document test progress.

6. **Handle failures gracefully**: Use proper error handling and screenshots for debugging.

## Future Enhancements

Potential improvements for the test suite:

- [ ] Add test for document upload in operational flow
- [ ] Add test for installment payment
- [ ] Add test for report generation and download
- [ ] Add test for application rejection flow
- [ ] Add parallel test execution for independent flows
- [ ] Add performance monitoring
- [ ] Add visual regression testing
- [ ] Add API testing for backend endpoints

## Support

For issues or questions:
1. Check the main README.md
2. Review test execution logs
3. Check Cypress documentation: https://docs.cypress.io

## Changelog

### Version 1.0.0 (2024-01-23)
- Initial full flow automation test
- Coverage for 8 main workflow steps
- Support for 4 user roles
- Custom commands for reusable actions
- Comprehensive documentation
