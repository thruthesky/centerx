describe('Login', function() {
    it('logins with the login form', function() {
        cy.visit('?user.login')
        cy.get('[name="email"]').type('thruthesky@gmail.com')
        cy.get('[name="password"]').type('12345a')

        cy.get('button[type="submit"]').click()
        cy.get('[id="logout-button"]').should('exist')
        cy.get('[id="login-button"]').should('not.exist')
        cy.get('[id="register-button"]').should('not.exist')
    })
})