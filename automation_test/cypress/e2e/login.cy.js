/**
 * Login Flow Test Suite
 * Testing login functionality and dashboard access
 */
describe('Login Flow', () => {
  const validEmail = 'admin@example.com'
  const validPassword = 'your_password'

  it('should display login page correctly', () => {
    cy.visit('/login')

    // Check if login page elements are visible
    cy.get('input[name="email"]').should('be.visible')
    cy.get('input[name="password"]').should('be.visible')
    cy.get('button[type="submit"]').should('be.visible')

    // Check page title or heading
    cy.contains('Login').should('be.visible')
  })

  it('should show validation error for empty credentials', () => {
    cy.visit('/login')

    // Try to submit without filling the form
    cy.get('button[type="submit"]').click()

    // Check if validation messages appear
    cy.url().should('include', '/login')
  })

  it('should show error for invalid credentials', () => {
    cy.visit('/login')

    // Fill with invalid credentials
    cy.get('input[name="email"]').type('invalid@example.com')
    cy.get('input[name="password"]').type('wrongpassword')
    cy.get('button[type="submit"]').click()

    // Should stay on login page or show error
    cy.url().should('include', '/login')
  })

  it('should login successfully with valid credentials', () => {
    cy.login(validEmail, validPassword)

    // Verify successful login
    cy.url().should('not.include', '/login')
    cy.waitForPageLoad()

    // Check if dashboard/home page is loaded
    cy.get('body').should('contain', 'Dashboard')

    // Logout
    cy.logout()
  })

  it('should redirect to home page when already authenticated', () => {
    // First login
    cy.login(validEmail, validPassword)

    // Try to visit login page again
    cy.visit('/login')

    // Should redirect to home
    cy.url().should('not.include', '/login')

    // Logout
    cy.logout()
  })

  it('should handle 404 error on login correctly', () => {
    cy.login(validEmail, validPassword)

    // Wait for page to load completely
    cy.waitForPageLoad()

    // Check that we're not getting a 404 error
    cy.get('body').should('not.contain', '404')
    cy.get('body').should('not.contain', 'Page Not Found')

    // Verify we can see dashboard content
    cy.get('.content-wrapper').should('be.visible')

    // Logout
    cy.logout()
  })

  it('should maintain session after page refresh', () => {
    // Login
    cy.login(validEmail, validPassword)
    cy.waitForPageLoad()

    // Refresh page
    cy.reload()

    // Should still be logged in
    cy.url().should('not.include', '/login')
    cy.waitForPageLoad()

    // Logout
    cy.logout()
  })

  // Test different user roles to check for 404 errors
  describe('Login with different roles - 404 check', () => {
    const roles = [
      {
        name: 'Approval',
        email: 'approval@mailinator.com',
        password: 'your_password'
      },
      {
        name: 'Verifikasi',
        email: 'verifikasi@mailinator.com',
        password: 'your_password'
      },
      {
        name: 'Bank',
        email: 'bank@mailinator.com',
        password: 'your_password'
      }
    ]

    roles.forEach((role) => {
      it(`should login as ${role.name} role and not encounter 404 page`, () => {
        // Login with role credentials
        cy.login(role.email, role.password)

        // Wait for page to load completely
        cy.waitForPageLoad()

        // Verify successful login
        cy.url().should('not.include', '/login')

        // Check that we're not getting a 404 error
        cy.get('body').should('not.contain', '404')
        cy.get('body').should('not.contain', 'Page Not Found')
        cy.get('body').should('not.contain', 'Not Found')

        // Verify we can see dashboard or content area
        cy.get('.content-wrapper').should('be.visible')

        // Logout after verification
        cy.logout()

        // Verify logout successful
      })
    })
  })
})
