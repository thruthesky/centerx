describe('Register', function() {
    it('Register with the register form', function() {
        const date = Date.now();

        cy.visit('?user.register')
        cy.get('[name="email"]').type(date + '-user@test.com')
        cy.get('[name="password"]').type('12345a')

        cy.get('button[type="submit"]').click()
        cy.get('[id="logout-button"]').should('exist')
        cy.get('[id="login-button"]').should('not.exist')
        cy.get('[id="register-button"]').should('not.exist')
    })
})