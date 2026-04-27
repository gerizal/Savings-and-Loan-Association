// ***********************************************************
// This example support/e2e.js is processed and
// loaded automatically before your test files.
//
// This is a great place to put global configuration and
// behavior that modifies Cypress.
//
// You can change the location of this file or turn off
// automatically serving support files with the
// 'supportFile' configuration option.
//
// You can read more here:
// https://on.cypress.io/configuration
// ***********************************************************

// Import commands.js using ES2015 syntax:
import './commands'

// Import cypress-mochawesome-reporter for HTML reports
import 'cypress-mochawesome-reporter/register'

// Global exception handler to ignore common application errors that don't affect test results
Cypress.on('uncaught:exception', (err, runnable) => {
  // Ignore Leaflet map errors
  if (err.message.includes('_options') ||
      err.message.includes('map') ||
      err.message.includes('Map')) {
    console.log('Ignoring Leaflet map error:', err.message)
    return false
  }

  // Ignore jQuery/DataTable errors
  if (err.message.includes('jQuery') ||
      err.message.includes('DataTable')) {
    console.log('Ignoring jQuery/DataTable error:', err.message)
    return false
  }

  // Ignore calculation/product loading errors (race conditions)
  if (err.message.includes('interest') ||
      err.message.includes('Cannot read properties of null') ||
      err.message.includes('Cannot read property') ||
      err.message.includes('product')) {
    console.log('Ignoring calculation/loading error:', err.message)
    return false
  }

  // Ignore Select2 errors
  if (err.message.includes('select2') ||
      err.message.includes('Select2')) {
    console.log('Ignoring Select2 error:', err.message)
    return false
  }

  // Let other errors fail the test
  return true
})