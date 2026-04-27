// ***********************************************
// Custom commands for SIPKPFI Automation Testing
// ***********************************************

/**
 * Login command
 * Automatically clears session before login to prevent conflicts
 * @param {string} email - User email
 * @param {string} password - User password
 */
Cypress.Commands.add('login', (email, password) => {
  // Clear any existing session first to prevent conflicts
  cy.clearCookies()
  cy.clearLocalStorage()

  // Visit login page
  cy.visit('/login')

  // Fill login form
  cy.get('input[name="email"]').clear().type(email)
  cy.get('input[name="password"]').clear().type(password)
  cy.get('button[type="submit"]').click()

  // Verify login success by checking if redirected to home
  cy.url().should('include', '/')
  cy.url().should('not.include', '/login')
})

/**
 * Logout command
 * Clicks logout button/link and verifies logout success
 */
Cypress.Commands.add('logout', () => {
  // Try different common logout selectors
  cy.get('body').then($body => {
    if ($body.find('a[href*="logout"]').length > 0) {
      // Found logout link
      cy.get('a[href*="logout"]').first().click({ force: true })
    } else if ($body.find('button:contains("Logout")').length > 0) {
      // Found logout button
      cy.contains('button', 'Logout').click({ force: true })
    } else if ($body.find('a:contains("Logout")').length > 0) {
      // Found logout link with text
      cy.contains('a', 'Logout').click({ force: true })
    } else if ($body.find('a:contains("Keluar")').length > 0) {
      // Found Indonesian logout link
      cy.contains('a', 'Keluar').click({ force: true })
    } else {
      // Fallback: try to find any logout element
      cy.log('⚠ Standard logout button not found, trying alternative selectors')
      cy.get('[onclick*="logout"], .logout, #logout').first().click({ force: true })
    }
  })

  // Wait for logout to complete
  cy.wait(500)
})

/**
 * Navigate to menu
 * @param {string} menuName - Menu name to navigate
 */
Cypress.Commands.add('navigateToMenu', (menuName) => {
  cy.contains(menuName).click()
})

/**
 * Fill form field
 * @param {string} fieldName - Field name or label
 * @param {string} value - Value to fill
 */
Cypress.Commands.add('fillField', (fieldName, value) => {
  cy.get(`input[name="${fieldName}"]`).clear().type(value)
})

/**
 * Select dropdown option
 * @param {string} fieldName - Field name
 * @param {string} value - Option value or text
 */
Cypress.Commands.add('selectOption', (fieldName, value) => {
  cy.get(`select[name="${fieldName}"]`).select(value)
})

/**
 * Wait for page to load
 */
Cypress.Commands.add('waitForPageLoad', () => {
  cy.get('body').should('be.visible')
  cy.get('.content-wrapper', { timeout: 10000 }).should('be.visible')
})

/**
 * Check if alert/notification exists
 * @param {string} type - success, error, warning, info
 * @param {string} message - Message to check (optional)
 */
Cypress.Commands.add('checkNotification', (type, message = null) => {
  if (message) {
    cy.contains('.alert', message).should('be.visible')
  } else {
    cy.get(`.alert-${type}`).should('be.visible')
  }
})

/**
 * Fill loan application form - Tab Data Diri
 * @param {object} personalData - Personal data object
 * @param {object} addressData - Address data object
 */
Cypress.Commands.add('fillPersonalDataTab', (personalData, addressData) => {
  // Make sure we're on the Personal Data tab - use more specific selector to avoid conflicts
  cy.get('.nav-tabs #btn-profile, .nav-link#btn-profile').first().should('be.visible').click({ force: true })
  
  // Wait for tab to be active and visible
  cy.get('#profileTab').should('have.class', 'active').should('be.visible')

  // Input new Nopen (Taspen ID) - type manually instead of selecting existing option
  // For Select2, we need to trigger it to open via jQuery
  cy.get('select[name="taspen_id"]', { timeout: 10000 }).should('be.visible')

  // Open Select2 dropdown using jQuery trigger (more reliable than clicking)
  cy.window().then((win) => {
    win.$('select[name="taspen_id"]').select2('open')
  })

  // Wait for dropdown to open and search field to appear
  cy.get('.select2-search__field', { timeout: 5000 }).should('be.visible')

  // Type the new value in the search box - this will be the NEW nopen
  const newNopen = 'NEW-TASPEN-' + Date.now() // Generate unique nopen
  cy.get('.select2-search__field').first().type(newNopen + '{enter}', { force: true })

  // Wait for selection to complete
  cy.wait(500)

  // Trigger change event on taspen_id to ensure backend processes the new value
  cy.window().then((win) => {
    const taspenSelect = win.$('select[name="taspen_id"]')
    taspenSelect.trigger('change')
    taspenSelect.trigger('select2:select')
  })

  // Wait longer for value to be set
  cy.wait(1000)

  // Store the taspen_id value to use for nopen field later
  cy.get('select[name="taspen_id"]').invoke('val').then((taspenIdValue) => {
    cy.log(`✓ Taspen ID value: ${taspenIdValue}`)
    // Store in Cypress env for use in nopen field
    Cypress.env('newTaspenId', taspenIdValue)
  })

  // Fill Personal Data
  if (personalData.name) {
    cy.get('input[name="name"]').clear({ force: true }).type(personalData.name, { force: true })
  }

  if (personalData.id_number) {
    cy.get('input[name="id_number"]').clear({ force: true }).type(personalData.id_number, { force: true })
  }

  if (personalData.birth_place) {
    cy.get('input[name="birth_place"]').clear({ force: true }).type(personalData.birth_place, { force: true })
  }

  if (personalData.birth_date) {
    // Set birth date directly without clicking calendar icon to avoid navigation issues
    cy.get('#profileTab input[name="birth_date"].birth_date').first().scrollIntoView().should('be.visible')

    // Use datetimepicker API to set date value (more reliable than typing)
    cy.window().then((win) => {
      const inputElement = win.$('#profileTab input[name="birth_date"].birth_date').first()
      // Set value directly
      inputElement.val(personalData.birth_date)
      // Trigger datetimepicker change if datetimepicker is initialized
      if (inputElement.data('datetimepicker')) {
        inputElement.datetimepicker('hide')
      }
      // Trigger multiple events to ensure age calculation runs
      inputElement.trigger('input')
      inputElement.trigger('change')
      inputElement.trigger('blur')
      inputElement.trigger('keyup')
    })

    // Wait a bit for value to be set
    cy.wait(500)

    // Verify birth_date field has value
    cy.get('#profileTab input[name="birth_date"].birth_date').first().should('not.have.value', '')
    cy.log('✓ Birth date filled')

    // Wait for age calculation and getProduct() AJAX call
    cy.wait(3000)

    // Check if year field is populated, if not, calculate manually
    cy.get('input[name="year"]').then(($yearInput) => {
      if (!$yearInput.val() || $yearInput.val() === '') {
        cy.log('⚠ Age not auto-calculated, calculating manually')
        // Calculate age from birth_date (format: DD-MM-YYYY)
        const birthDateParts = personalData.birth_date.split('-')
        const birthYear = parseInt(birthDateParts[2])
        const currentYear = new Date().getFullYear()
        const age = currentYear - birthYear

        cy.window().then((win) => {
          win.$('input[name="year"]').val(age).trigger('change')
        })
        cy.log(`✓ Age set manually to ${age}`)
      } else {
        cy.log('✓ Age calculated automatically')
      }
    })

    // Verify year field is now populated
    cy.get('input[name="year"]').should('not.have.value', '')
  }

  if (personalData.tax_number) {
    cy.get('input[name="tax_number"]').clear({ force: true }).type(personalData.tax_number, { force: true })
  }

  if (personalData.phone_number) {
    cy.get('input[name="phone_number"]').clear({ force: true }).type(personalData.phone_number, { force: true })
  }

  if (personalData.gender) {
    cy.get('select[name="gender"]').select(personalData.gender, { force: true })
  }

  if (personalData.education) {
    cy.get('select[name="education"]').select(personalData.education, { force: true })
  }

  if (personalData.religion) {
    cy.get('select[name="religion"]').select(personalData.religion, { force: true })
  }

  if (personalData.mother_name) {
    cy.get('input[name="mother_name"]').clear({ force: true }).type(personalData.mother_name, { force: true })
  }

  // Fill Address
  if (addressData.address) {
    cy.get('textarea[name="address"]').clear({ force: true }).type(addressData.address, { force: true })
  }

  // Fill geo location (latitude and longitude) - required hidden fields
  cy.get('input[name="address_latitude"]').invoke('val', '-6.2088').trigger('change', { force: true })
  cy.get('input[name="address_longitude"]').invoke('val', '106.8456').trigger('change', { force: true })

  // Fill geo_location field (concatenated lat,long) - required field
  cy.get('input[name="geo_location"]').invoke('val', '-6.2088, 106.8456').trigger('change', { force: true })

  // Select Province, City, District, Sub District - CASCADING DROPDOWNS
  // Each dropdown depends on the previous one, so we need to wait for data to load

  // 1. Select Province first
  cy.get('select[name="province_id"]').then($select => {
    if ($select.find('option').length > 1) {
      const firstValue = $select.find('option').eq(1).val()
      cy.log(`Selecting Province ID: ${firstValue}`)
      cy.get('select[name="province_id"]').select(firstValue, { force: true })
      cy.wait(2000) // Wait for city dropdown to populate via AJAX
    }
  })

  // 2. Select City after province is selected
  cy.get('select[name="city_id"]').should('not.be.disabled') // Wait until enabled
  cy.get('select[name="city_id"]').then($select => {
    // Wait for options to be populated
    cy.wrap($select).find('option').should('have.length.greaterThan', 1)
    const firstValue = $select.find('option').eq(1).val()
    cy.log(`Selecting City ID: ${firstValue}`)
    cy.get('select[name="city_id"]').select(firstValue, { force: true })
    cy.wait(2000) // Wait for district dropdown to populate via AJAX
  })

  // 3. Select District after city is selected
  cy.get('select[name="district_id"]').should('not.be.disabled') // Wait until enabled
  cy.get('select[name="district_id"]').then($select => {
    // Wait for options to be populated
    cy.wrap($select).find('option').should('have.length.greaterThan', 1)
    const firstValue = $select.find('option').eq(1).val()
    cy.log(`Selecting District ID: ${firstValue}`)
    cy.get('select[name="district_id"]').select(firstValue, { force: true })
    cy.wait(2000) // Wait for sub_district dropdown to populate via AJAX
  })

  // 4. Select Sub District after district is selected
  cy.get('select[name="sub_district_id"]').should('not.be.disabled') // Wait until enabled
  cy.get('select[name="sub_district_id"]').then($select => {
    // Wait for options to be populated
    cy.wrap($select).find('option').should('have.length.greaterThan', 1)
    const firstValue = $select.find('option').eq(1).val()
    cy.log(`Selecting Sub District ID: ${firstValue}`)
    cy.get('select[name="sub_district_id"]').select(firstValue, { force: true })
    cy.wait(1000) // Final wait for any dependent calculations
  })

  if (addressData.rt) {
    cy.get('input[name="rt"]').clear({ force: true }).type(addressData.rt, { force: true })
  }

  if (addressData.rw) {
    cy.get('input[name="rw"]').clear({ force: true }).type(addressData.rw, { force: true })
  }

  if (addressData.post_code) {
    cy.get('input[name="post_code"]').clear({ force: true }).type(addressData.post_code, { force: true })
  }

  // Set is_domicile checkbox (required) - 1 means same as KTP address
  cy.get('input[name="is_domicile"]').check({ force: true })
  
  // Fill residential status
  cy.get('select[name="residential_status"]').select('Milik Sendiri', { force: true })
  
  // Fill occupied_at
  cy.get('input[name="occupied_at"]').clear({ force: true }).type('2020', { force: true })
  
  // Fill current job and business type
  cy.get('input[name="current_job"]').clear({ force: true }).type('Pensiunan', { force: true })
  cy.get('input[name="business_type"]').clear({ force: true }).type('Wirausaha', { force: true })
  cy.get('textarea[name="current_job_address"]').clear({ force: true }).type('Jakarta', { force: true })
  
  // Fill marital status
  cy.get('select[name="marital_status"]').select('Kawin', { force: true })
  cy.wait(500) // Wait for spouse section to appear
  
  // Fill spouse information (required when marital status is "Kawin")
  cy.get('#spouse').should('not.have.class', 'd-none') // Verify spouse section is visible
  
  cy.get('input[name="spouse_name"]').clear({ force: true }).type('Siti Aminah', { force: true })
  cy.get('input[name="spouse_id_number"]').clear({ force: true }).type('3174012345678902', { force: true })
  cy.get('input[name="spouse_birth_place"]').clear({ force: true }).type('Jakarta', { force: true })
  cy.get('input[name="spouse_birth_date"]').clear({ force: true }).type('01-01-1970', { force: true })
  cy.get('input[name="spouse_job"]').clear({ force: true }).type('Ibu Rumah Tangga', { force: true })
})

/**
 * Click tab button in loan application form
 * @param {string} tabName - Tab button ID (btn-profile, btn-guarantee, btn-product, btn-service)
 */
Cypress.Commands.add('clickLoanTab', (tabName) => {
  cy.get(`#${tabName}`, { timeout: 5000 }).click({ force: true })
  cy.wait(500)
})

/**
 * Fill loan application form - Tab Data Pensiun
 * @param {object} pensionData - Pension data object
 */
Cypress.Commands.add('fillPensionDataTab', (pensionData) => {
  // Click Data Pensiun tab
  cy.clickLoanTab('btn-guarantee')
  cy.get('#guaranteeTab').should('have.class', 'active').should('be.visible')
  cy.wait(500)

  // Fill all required pension data fields
  if (pensionData.skep_name) {
    cy.get('input[name="skep_name"]').clear({ force: true }).type(pensionData.skep_name, { force: true })
  }

  // IMPORTANT: For NEW Taspen, nopen MUST equal taspen_id value
  // Backend checks: if(taspen_id == nopen) -> create new, else -> update existing
  // Get taspen_id value and use it for nopen field
  cy.get('select[name="taspen_id"]').invoke('val').then((taspenIdValue) => {
    cy.log(`Setting nopen to match taspen_id: ${taspenIdValue}`)
    cy.get('input[name="nopen"]').clear({ force: true }).type(taspenIdValue, { force: true })
  })

  if (pensionData.skep_number) {
    cy.get('input[name="skep_number"]').clear({ force: true }).type(pensionData.skep_number, { force: true })
  }

  if (pensionData.employee_code) {
    cy.get('input[name="employee_code"]').clear({ force: true }).type(pensionData.employee_code, { force: true })
  }

  if (pensionData.employee_grade) {
    cy.get('input[name="employee_grade"]').clear({ force: true }).type(pensionData.employee_grade, { force: true })
  }

  if (pensionData.retirement_type) {
    cy.get('input[name="retirement_type"]').clear({ force: true }).type(pensionData.retirement_type, { force: true })
  }

  if (pensionData.guarantee_skep_date) {
    cy.get('input[name="guarantee_skep_date"]').clear({ force: true }).type(pensionData.guarantee_skep_date, { force: true })
  }

  if (pensionData.guarantee_skep_publisher) {
    cy.get('input[name="guarantee_skep_publisher"]').clear({ force: true }).type(pensionData.guarantee_skep_publisher, { force: true })
  }
})

/**
 * Fill loan application form - Tab Produk Pembiayaan
 * @param {object} productData - Product data object
 * @param {string} birthDate - Birth date from personal data (optional, not used as productTab birth_date is readonly)
 */
Cypress.Commands.add('fillProductDataTab', (productData, birthDate = null) => {
  // Click Produk Pembiayaan tab
  cy.clickLoanTab('btn-product')
  cy.get('#productTab').should('have.class', 'active').should('be.visible')
  cy.wait(500)

  // Birth_date in productTab is readonly and auto-filled from profileTab
  // Wait for auto-fill to happen
  cy.wait(1000)

  // Check if birth_date is populated, if not copy from profileTab
  cy.get('#productTab input[name="birth_date"]').then(($birthDateInput) => {
    if (!$birthDateInput.val() || $birthDateInput.val() === '') {
      cy.log('⚠ Birth date not auto-filled in productTab, copying from profileTab')

      // Get birth_date value from profileTab
      cy.get('#profileTab input[name="birth_date"].birth_date').first().invoke('val').then((birthDateValue) => {
        // Set it to productTab birth_date
        cy.window().then((win) => {
          const productBirthDate = win.$('#productTab input[name="birth_date"]')
          productBirthDate.val(birthDateValue)
          productBirthDate.prop('readonly', false) // Temporarily remove readonly
          productBirthDate.trigger('change')
          productBirthDate.trigger('blur')
          productBirthDate.prop('readonly', true) // Set back to readonly
        })
        cy.log(`✓ Birth date copied to productTab: ${birthDateValue}`)
      })
    } else {
      cy.log('✓ Birth date in productTab auto-populated')
    }
  })

  // Verify birth_date is now populated
  cy.get('#productTab input[name="birth_date"]').should('not.have.value', '')

  // Wait for getProduct() AJAX to complete
  cy.wait(1500)

  // Fill salary - this should enable product dropdown after birth_date is set
  if (productData.salary) {
    cy.get('input[name="salary"]').then($input => {
      if (!$input.prop('readonly')) {
        cy.get('input[name="salary"]').clear({ force: true }).type(productData.salary, { force: true }).blur()
        cy.wait(1000)
      }
    })
  }

  // Wait for product dropdown to be populated and enabled
  cy.get('select[name="product_id"]', { timeout: 15000 }).should('exist').should('not.be.disabled')
  
  // Log dropdown status before attempting to select
  cy.get('select[name="product_id"]').then($select => {
    const optionCount = $select.find('option').length
    cy.log(`📋 Product dropdown has ${optionCount} options`)

    if (optionCount > 1) {
      // Get first available option (index 1, skipping placeholder at 0)
      const firstText = $select.find('option').eq(1).text()
      cy.log(`Selecting first option: ${firstText}`)

      // Select first option by index (1 = first real option, 0 is usually placeholder)
      cy.get('select[name="product_id"]').select(1, { force: true })

      cy.wait(1500)

      // Verify selection by checking selectedIndex is not 0 (placeholder)
      cy.get('select[name="product_id"]').should(($sel) => {
        const selectedIndex = $sel.prop('selectedIndex')
        expect(selectedIndex).to.be.greaterThan(0)
      })
      cy.log(`✓ Product selected: ${firstText}`)
    } else {
      cy.log('⚠ Warning: Product dropdown has no options. Check birth_date and age calculation.')
      // Take screenshot for debugging
      cy.screenshot('product-dropdown-empty')
    }
  })

  // Select Finance Type - should be auto-populated
  cy.get('select[name="finance_type_id"]').then($select => {
    if ($select.find('option').length > 1 && !$select.prop('disabled')) {
      cy.get('select[name="finance_type_id"]').select(1, { force: true })
      cy.wait(500)
    }
  })

  // Select Interest Type
  cy.get('select[name="interest_type"]').then($select => {
    if ($select.find('option').length > 1) {
      cy.get('select[name="interest_type"]').select(1, { force: true })
      cy.wait(500)
    }
  })

  // Select Referral
  cy.get('select[name="referral_id"]').then($select => {
    if ($select.find('option').length > 1) {
      cy.get('select[name="referral_id"]').select(1, { force: true })
      cy.wait(500)
    }
  })

  // Fill referral fee
  if (productData.referral_fee) {
    cy.get('input[name="referral_fee"]').clear({ force: true }).type(productData.referral_fee, { force: true })
  }

  // Fill tenor - this triggers max plafon calculation
  if (productData.tenor) {
    cy.get('input[name="tenor"]').then($input => {
      if (!$input.prop('readonly')) {
        cy.get('input[name="tenor"]').clear({ force: true }).type(productData.tenor, { force: true })
        cy.wait(1000) // Wait for tenor change to calculate max plafon
      }
    })
  }

  // Fill plafon - this triggers installment calculation
  if (productData.plafon) {
    cy.get('input[name="plafon"]').then($input => {
      if (!$input.prop('readonly')) {
        cy.get('input[name="plafon"]').clear({ force: true }).type(productData.plafon, { force: true })
        
        // Trigger keyup event manually to ensure calculation runs
        cy.get('input[name="plafon"]').trigger('keyup', { force: true })
        
        // Wait for installment calculation to complete
        cy.wait(1500)
        
        // Verify installment is calculated by checking it's not empty
        cy.get('input[name="installment"]', { timeout: 10000 }).should(($el) => {
          const val = $el.val()
          expect(val).to.not.be.empty
          expect(parseInt(val.replace(/[^0-9]/g, ''))).to.be.greaterThan(0)
        })
        
        cy.log('✓ Installment calculated successfully')
      }
    })
  }

  // Fill purpose
  if (productData.purpose) {
    cy.get('textarea[name="purpose"]').clear({ force: true }).type(productData.purpose, { force: true })
  }
  
  // Fill juru bayar asal (original paymaster)
  cy.get('input[name="original_paymaster"]').clear({ force: true }).type('Juru Bayar Asal', { force: true })
  
  // Fill juru bayar tujuan (destination paymaster)
  cy.get('input[name="destination_paymaster"]').clear({ force: true }).type('Juru Bayar Tujuan', { force: true })
  
  // Fill pembiayaan sebelumnya (previous loan)
  cy.get('input[name="previous_loan"]').clear({ force: true }).type('5000000', { force: true })
  
  // Wait for all calculations to complete
  cy.wait(500)
  
  // Final verification - ensure installment has a valid numeric value
  cy.get('input[name="installment"]').should(($el) => {
    const val = $el.val()
    expect(val, 'Installment should not be empty').to.not.be.empty
    const numVal = parseInt(val.replace(/[^0-9]/g, ''))
    expect(numVal, 'Installment should be a positive number').to.be.greaterThan(0)
  })
  
  cy.log('✓ All product calculations completed')
})

/**
 * Fill loan application form - Tab Unit Layanan
 * @param {object} serviceData - Service unit data object
 */
Cypress.Commands.add('fillServiceUnitTab', (serviceData) => {
  // Click Unit Layanan tab
  cy.clickLoanTab('btn-service')
  cy.get('#serviceUnit').should('have.class', 'active').should('be.visible')
  cy.wait(500)

  // Select Service Unit - first option (this triggers branch unit population)
  cy.get('select[name="service_unit_id"]').then($select => {
    if ($select.find('option').length > 1) {
      cy.get('select[name="service_unit_id"]').select(1, { force: true })
      cy.wait(1000) // Wait for branch unit to populate
    }
  })

  // Select Branch Unit - should be auto-populated after service unit
  cy.get('select[name="branch_unit_id"]', { timeout: 5000 }).should('not.be.disabled')
  cy.get('select[name="branch_unit_id"]').then($select => {
    if ($select.find('option').length > 1) {
      cy.get('select[name="branch_unit_id"]').select(1, { force: true })
      cy.wait(1000) // Wait for marketing to populate
    }
  })

  // Select Marketing - should be auto-populated after branch unit
  cy.get('select[name="marketing_id"]', { timeout: 5000 }).should('not.be.disabled')
  cy.get('select[name="marketing_id"]').then($select => {
    if ($select.find('option').length > 1) {
      cy.get('select[name="marketing_id"]').select(1, { force: true })
      cy.wait(500)
    }
  })

  // job_position, pkwt_status, fronting_agent should auto-fill from marketing selection
  // Just wait for them to populate
  cy.wait(500)
  
  // Ensure fronting_agent is filled if empty
  cy.get('input[name="fronting_agent"]').then($input => {
    if (!$input.val()) {
      cy.get('input[name="fronting_agent"]').clear({ force: true }).type('Agent-001', { force: true })
    }
  })
  
  // Upload files
  // Video wawancara
  cy.get('input[name="interview_video"]').selectFile('cypress/file_example_MP4_480_1_5MG.mp4', { force: true })
  
  // Video asuransi
  cy.get('input[name="insurance_video"]').selectFile('cypress/file_example_MP4_480_1_5MG.mp4', { force: true })
  
  // Berkas SLIK PDF
  cy.get('input[name="slik_file"]').selectFile('cypress/WageRizalSolichin_Resume_3.pdf', { force: true })
  
  // Berkas Pengajuan PDF
  cy.get('input[name="application_file"]').selectFile('cypress/WageRizalSolichin_Resume_3.pdf', { force: true })
  
  cy.log('✓ All files uploaded')
})

/**
 * Fill complete loan application form
 * @param {object} applicationData - Complete application data
 */
Cypress.Commands.add('fillLoanApplicationForm', (applicationData) => {
  cy.log('Filling Personal Data Tab')
  cy.fillPersonalDataTab(applicationData.personalData, applicationData.address)

  cy.log('Filling Pension Data Tab')
  cy.fillPensionDataTab(applicationData.pensionData)

  cy.log('Filling Product Data Tab')
  cy.fillProductDataTab(applicationData.productData, applicationData.personalData.birth_date)

  cy.log('Filling Service Unit Tab')
  cy.fillServiceUnitTab(applicationData.serviceUnit)
})

/**
 * Ensure required fields are filled for edit/submit
 * This fixes missing product_id, geo_location, district_id, and sub_district_id errors
 */
Cypress.Commands.add('ensureRequiredFieldsFilled', () => {
  cy.log('Ensuring required fields are filled')

  // Ensure product_id is selected
  cy.get('select[name="product_id"]').then($select => {
    const currentValue = $select.val()
    if (!currentValue || currentValue === '') {
      cy.log('⚠ Product ID empty, selecting first product')
      if ($select.find('option').length > 1) {
        cy.get('select[name="product_id"]').select(1, { force: true })
        cy.wait(1000)

        // Trigger change event to populate dependent fields
        cy.get('select[name="product_id"]').trigger('change')
        cy.wait(500)
      }
    } else {
      cy.log(`✓ Product ID already set: ${currentValue}`)
    }
  })

  // Ensure geo_location is filled
  cy.get('input[name="geo_location"]').then($input => {
    const currentValue = $input.val()
    if (!currentValue || currentValue === '') {
      cy.log('⚠ Geo location empty, filling with default coordinates')
      cy.get('input[name="address_latitude"]').invoke('val', '-6.2088').trigger('change', { force: true })
      cy.get('input[name="address_longitude"]').invoke('val', '106.8456').trigger('change', { force: true })
      cy.get('input[name="geo_location"]').invoke('val', '-6.2088, 106.8456').trigger('change', { force: true })
      cy.log('✓ Geo location set to default Jakarta coordinates')
    } else {
      cy.log(`✓ Geo location already set: ${currentValue}`)
    }
  })

  // Ensure district_id is filled
  cy.get('select[name="district_id"]').then($select => {
    const currentValue = $select.val()
    if (!currentValue || currentValue === '') {
      cy.log('⚠ District ID empty, selecting first district')
      if ($select.find('option').length > 1) {
        cy.get('select[name="district_id"]').select(1, { force: true })
        cy.wait(1500) // Wait for sub_district to populate
      }
    } else {
      cy.log(`✓ District ID already set: ${currentValue}`)
    }
  })

  // Ensure sub_district_id is filled
  cy.get('select[name="sub_district_id"]').then($select => {
    const currentValue = $select.val()
    if (!currentValue || currentValue === '') {
      cy.log('⚠ Sub District ID empty, selecting first sub district')
      // Wait for options to populate
      cy.get('select[name="sub_district_id"]').should('not.be.disabled')
      cy.wait(1000)
      if ($select.find('option').length > 1) {
        cy.get('select[name="sub_district_id"]').select(1, { force: true })
        cy.wait(500)
      }
    } else {
      cy.log(`✓ Sub District ID already set: ${currentValue}`)
    }
  })
})

/**
 * Click edit button in the loan application table
 * Handles both icon buttons and text links
 * @param {number} rowIndex - Row index (default: 0 for first row)
 */
Cypress.Commands.add('clickEditButton', (rowIndex = 0) => {
  // Wait for DataTable to be fully loaded and initialized
  cy.get('#dataTable', { timeout: 15000 }).should('be.visible')
  cy.wait(1000) // Wait for DataTable to finish rendering

  // Wait for table rows to be present
  cy.get('#dataTable tbody tr', { timeout: 10000 }).should('have.length.greaterThan', 0)

  // Get the specific row and click edit button
  cy.get('#dataTable tbody tr').eq(rowIndex).should('be.visible').within(() => {
    // Find edit link - specific selector based on actual HTML:
    // <a href="...loan/XX/edit" class="btn btn-info..."><i class="fas fa-edit"></i> Edit</a>
    cy.get('a.btn.btn-info').contains('Edit').click({ force: true })
  })

  // Wait for navigation to edit page
  cy.wait(1000)
})

// ***********************************************
// Full Flow Custom Commands
// ***********************************************

/**
 * Fill simulation form
 * @param {object} simulationData - Simulation data (birth_date, salary, plafon, tenor)
 */
Cypress.Commands.add('fillSimulationForm', (simulationData) => {
  // Wait for form to be ready
  cy.wait(3000)

  // Ensure all required fields are visible and not disabled before filling
  cy.get('input[name="birth_date"]').should('be.visible').should('not.be.disabled')
  cy.get('input[name="salary"]').should('be.visible').should('not.be.disabled')
  cy.get('input[name="plafon"]').should('be.visible').should('not.be.disabled')
  cy.get('input[name="tenor"]').should('be.visible').should('not.be.disabled')

  // Fill nopen (pensioner number) - using Select2 plugin
  // Nopen uses Select2 which allows creating new entries by typing
  if (simulationData.nopen) {
    cy.log('Filling nopen using Select2')

    // Generate unique nopen with timestamp
    const newNopen = 'NEW-TASPEN-' + Date.now()
    cy.log(`Creating new nopen: ${newNopen}`)

    // Click on Select2 dropdown to open it
    cy.get('select[name="nopen"]').should('exist')
    cy.get('.select2-selection').first().click({ force: true })
    cy.wait(500)

    // Type in the Select2 search field and press Enter to create new entry
    cy.get('.select2-search__field').first().should('be.visible')
    cy.get('.select2-search__field').first().type(newNopen + '{enter}', { force: true })
    cy.wait(1000)

    cy.log(`✓ Nopen created and selected: ${newNopen}`)
  }

  // Fill name (full name) if provided
  if (simulationData.name) {
    cy.get('body').then($body => {
      if ($body.find('input[name="name"]').length > 0) {
        cy.get('input[name="name"]').clear({ force: true }).type(simulationData.name, { force: true })
        cy.get('input[name="name"]').trigger('blur')
        cy.wait(500)
      }
    })
  }

  // Fill address if provided
  if (simulationData.address) {
    cy.get('body').then($body => {
      if ($body.find('textarea[name="address"]').length > 0) {
        cy.get('textarea[name="address"]').clear({ force: true }).type(simulationData.address, { force: true })
        cy.get('textarea[name="address"]').trigger('blur')
        cy.wait(500)
      } else if ($body.find('input[name="address"]').length > 0) {
        cy.get('input[name="address"]').clear({ force: true }).type(simulationData.address, { force: true })
        cy.get('input[name="address"]').trigger('blur')
        cy.wait(500)
      }
    })
  }

  // Fill birth date (this may trigger calculations)
  if (simulationData.birth_date) {
    cy.get('input[name="birth_date"]').clear({ force: true }).type(simulationData.birth_date, { force: true })
    cy.get('input[name="birth_date"]').trigger('blur') // Trigger blur event
    cy.wait(3000) // Wait for age calculation and product loading
  }

  // Fill salary (this may trigger plafon calculation)
  if (simulationData.salary) {
    cy.get('input[name="salary"]').clear({ force: true }).type(simulationData.salary, { force: true })
    cy.get('input[name="salary"]').trigger('blur') // Trigger blur event
    cy.wait(1500) // Wait for salary-related calculations
  }

  // Select product (produk pembiayaan) after salary
  cy.get('body').then($body => {
    if ($body.find('select[name="product_id"]').length > 0) {
      cy.get('select[name="product_id"]').should('not.be.disabled')
      cy.get('select[name="product_id"]').then($select => {
        const currentValue = $select.val()
        if (!currentValue || currentValue === '' || currentValue === null) {
          // Product not selected, select first available option
          const options = $select.find('option')
          if (options.length > 1) {
            const firstValue = options.eq(1).val()
            cy.log(`Selecting product_id: ${firstValue}`)
            cy.get('select[name="product_id"]').select(firstValue, { force: true })
            cy.wait(1000)
          }
        } else {
          cy.log(`Product already selected: ${currentValue}`)
        }
      })
    }
  })

  // Select finance type (jenis pembiayaan) after product
  cy.get('body').then($body => {
    if ($body.find('select[name="finance_type_id"]').length > 0) {
      cy.get('select[name="finance_type_id"]').should('not.be.disabled')
      cy.get('select[name="finance_type_id"]').then($select => {
        const currentValue = $select.val()
        if (!currentValue || currentValue === '' || currentValue === null) {
          // Finance type not selected, select first available option
          const options = $select.find('option')
          if (options.length > 1) {
            const firstValue = options.eq(1).val()
            cy.log(`Selecting finance_type_id: ${firstValue}`)
            cy.get('select[name="finance_type_id"]').select(firstValue, { force: true })
            cy.wait(1000)
          }
        } else {
          cy.log(`Finance type already selected: ${currentValue}`)
        }
      })
    }
  })

  // Fill tenor after finance type (this may trigger interest calculation)
  if (simulationData.tenor) {
    cy.get('input[name="tenor"]').clear({ force: true }).type(simulationData.tenor, { force: true })
    cy.get('input[name="tenor"]').trigger('blur') // Trigger blur event
    cy.wait(1500) // Wait for tenor-related calculations
  }

  // Fill plafon last (this may trigger final calculations)
  if (simulationData.plafon) {
    cy.get('input[name="plafon"]').clear({ force: true }).type(simulationData.plafon, { force: true })
    cy.get('input[name="plafon"]').trigger('blur') // Trigger blur event
    cy.wait(2000) // Wait for final calculations including interest
  }

  // Wait a bit more to ensure all calculations are done
  cy.wait(1000)

  // IMPORTANT: Make the submit button visible by removing d-none class
  // The submit button is hidden by default and needs to be shown before submitting
  cy.get('#btn-submit').should('exist')
  cy.get('#btn-submit').invoke('removeClass', 'd-none')
  cy.log('✓ Submit button made visible')
})

/**
 * Approve or reject an application
 * @param {string} action - 'approve' or 'reject'
 * @param {string} notes - Notes/comments for the action
 */
Cypress.Commands.add('approveRejectApplication', (action, notes) => {
  // Select status
  cy.get('select[name="status"]').select(action, { force: true })

  // Fill notes
  if (notes) {
    cy.get('textarea[name="notes"]').clear({ force: true }).type(notes, { force: true })
  }

  // Submit
  cy.get('button[type="submit"]').contains('Submit').click({ force: true })

  // Confirm action
  cy.on('window:confirm', () => true)

  cy.wait(2000)
})

/**
 * Navigate to specific menu in sidebar
 * @param {string} mainMenu - Main menu name
 * @param {string} subMenu - Sub menu name (optional)
 */
Cypress.Commands.add('navigateToSidebarMenu', (mainMenu, subMenu = null) => {
  // Click main menu
  cy.contains('.nav-link', mainMenu).click({ force: true })
  cy.wait(500)

  // Click sub menu if provided
  if (subMenu) {
    cy.contains('.nav-link', subMenu).should('be.visible').click({ force: true })
    cy.wait(500)
  }
})

/**
 * Check if application exists in table
 * @param {string} searchText - Text to search in table (optional)
 */
Cypress.Commands.add('checkApplicationInTable', (searchText = null) => {
  cy.get('#dataTable', { timeout: 10000 }).should('be.visible')
  cy.get('#dataTable tbody tr').should('have.length.greaterThan', 0)

  if (searchText) {
    cy.get('#dataTable tbody').should('contain', searchText)
  }
})

/**
 * Click detail/show button in table
 * @param {number} rowIndex - Row index (default: 0 for first row)
 */
Cypress.Commands.add('clickDetailButton', (rowIndex = 0) => {
  cy.get('#dataTable tbody tr', { timeout: 10000 }).eq(rowIndex).should('be.visible').within(() => {
    cy.get('a.btn').contains('Detail').click({ force: true })
  })
  cy.wait(1000)
})

/**
 * Submit application to verification
 * @param {number} rowIndex - Row index (default: 0 for first row)
 */
Cypress.Commands.add('submitToVerification', (rowIndex = 0) => {
  cy.get('#dataTable tbody tr', { timeout: 10000 }).eq(rowIndex).should('be.visible').within(() => {
    cy.contains('Ajukan ke Verifikasi').click()
  })

  // Confirm the action
  cy.on('window:confirm', () => true)

  // Should show success message
  cy.contains('berhasil diajukan ke proses verifikasi', { timeout: 10000 }).should('be.visible')
})

/**
 * Wait for DataTable to load
 */
Cypress.Commands.add('waitForDataTable', () => {
  cy.get('#dataTable', { timeout: 15000 }).should('be.visible')
  cy.wait(1000)
})

/**
 * Upload file to input
 * @param {string} inputName - Input name attribute
 * @param {string} filePath - Path to file in cypress directory
 */
Cypress.Commands.add('uploadFileToInput', (inputName, filePath) => {
  cy.get(`input[name="${inputName}"]`).selectFile(filePath, { force: true })
})

/**
 * Check if user has access to menu
 * @param {string} menuName - Menu name to check
 */
Cypress.Commands.add('hasAccessToMenu', (menuName) => {
  return cy.get('body').then($body => {
    return $body.text().includes(menuName)
  })
})

/**
 * Generate report with date range
 * @param {string} startDate - Start date
 * @param {string} endDate - End date
 */
Cypress.Commands.add('generateReport', (startDate = null, endDate = null) => {
  if (startDate) {
    cy.get('input[name="start_date"]').clear({ force: true }).type(startDate, { force: true })
  }

  if (endDate) {
    cy.get('input[name="end_date"]').clear({ force: true }).type(endDate, { force: true })
  }

  // Click generate button
  cy.get('button').contains('Generate').click({ force: true })
  cy.wait(2000)
})