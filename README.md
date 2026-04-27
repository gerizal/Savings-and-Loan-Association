# Savings and Loan Association Management System

A management system for savings and loan cooperatives (KSP) designed to handle the full lifecycle of pension/taspen loan applications — from simulation through installment settlement.

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| Framework | Laravel 11 |
| Language | PHP 8.2+ |
| Database | MySQL 8.0+ / MariaDB 10.6+ |
| Cache & Session | Redis 7+ |
| Application Server | Laravel Octane (Swoole) |
| Frontend Build | Vite 5 |
| Storage | Azure Blob Storage |
| PDF Generation | barryvdh/laravel-dompdf |
| Excel Export | Maatwebsite/Laravel-Excel |
| Datatables | Yajra Laravel Datatables |

---

## Features

- **Loan Simulation** — calculate estimated installments, maximum loan ceiling, and generate simulation documents (PDF)
- **Loan Application** — manage debtor data, documents, domicile, family members, salary deductions & allowances
- **SLIK Check (OJK)** — verify credit history through the Financial Information Services System
- **Document Verification** — validate document completeness and conduct field visits
- **Bank Approval** — bank-side review and loan approval
- **Contract** — generate loan contracts with automatic installment schedules
- **Disbursement (Dropping)** — submission file, guarantee submission, and fund disbursement
- **Installment Monitoring** — track monthly payment schedules
- **Settlement** — early loan payoff before maturity date
- **Monitoring & Reports** — dashboard monitoring and export reports (Excel/PDF)
- **Master Data** — manage products, branches, service units, banks, referrals, and users

---

## Business Process Flow

```
LOAN PROCESS FLOW
═══════════════════════════════════════════════════════════════════════

1. LOAN SIMULATION
   └─ Marketing inputs prospective debtor data (pension / taspen)
   └─ System calculates estimated installment, max ceiling, tenor, etc.
   └─ Output: simulation document in PDF format

2. LOAN APPLICATION
   └─ Marketing creates an application based on the simulation
   └─ Upload documents (ID card, Pension Decree, Taspen Card, etc.)
   └─ Complete data: personal info, domicile, family members,
      salary deductions / allowances
   └─ Status: Draft → Submitted

3. SLIK CHECK (Financial Information Services System — OJK)
   └─ SLIK officer checks debtor credit history via OJK / BI portal
   └─ Status: Queue → Approve / Reject
   └─ If Rejected → application cancelled, returned to marketing

4. DOCUMENT VERIFICATION
   └─ Verification officer validates document completeness and authenticity
   └─ Field visit / on-site verification if required
   └─ Status: Queue → Approve / Reject
   └─ If Rejected → application returned for correction

5. BANK APPROVAL
   └─ Bank reviews the application and decides on approval
   └─ Status: Queue → Approve / Reject
   └─ If Approved → proceed to contract creation

6. CONTRACT
   └─ System generates the loan contract document
   └─ Installment schedule automatically created (tenor × installment amount)
   └─ Contract signed by debtor and cooperative

7. DISBURSEMENT (DROPPING)
   ├─ Submission File      : complete documents submitted to bank
   ├─ Submission Guarantee : collateral / guarantee submitted to bank
   └─ Dropping             : loan funds disbursed by bank
      └─ Status: Queue → On Process → Done

8. INSTALLMENT MONITORING
   └─ Installment schedule stored per month per contract
   └─ Payment status monitored each period
   └─ Settlement processed if debtor pays off before maturity

═══════════════════════════════════════════════════════════════════════
ROLES & ACCESS
═══════════════════════════════════════════════════════════════════════

  Role             Primary Access
  ──────────────   ──────────────────────────────────────────────────
  Admin            Full access — all modules and master data
  Marketing        Simulation + Application (create & submit)
  SLIK             SLIK check module (queue, approve, reject)
  Verification     Document verification module
  Bank Approval    Loan approval module
  Bank             Disbursement and dropping monitoring
  Finance          Installment, settlement, and financial reports

═══════════════════════════════════════════════════════════════════════
```

---

## Quick Start

For the complete setup guide (requirements, installation, environment configuration, production deployment) see **[SETUP.md](SETUP.md)**.

---

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
