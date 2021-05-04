describe('Admin login', function() {
    it('login form', function() {
        cy.visit('http://localhost/?user.login')
        cy.get('[name="email"]').type('thruthesky@gmail.com')
        cy.get('[name="password"]').type('12345a')

        cy.get('button[type="submit"]').click()

    })
})