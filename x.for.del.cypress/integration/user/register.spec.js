/// <reference types="cypress" />

describe('Register', function() {
    it('Register with the register form', function() {
        cy.visit('/');

        const date = Date.now();

        cy.getElement('register-button').click()
        cy.getElement('register-form').should('exist')

        cy.getElement('email-input').type(date + '-user@test.com')
        cy.getElement('password-input').type('12345a')

        cy.getElement('submit-button').click()
        cy.getElement('logout-button').should('exist')
        cy.getElement('login-button').should('not.exist')
        cy.getElement('register-button').should('not.exist')
    })
})