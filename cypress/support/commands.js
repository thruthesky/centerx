// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

/**
 * Login via request.
 * 
 * @note only use this when not testing login page.
 */
Cypress.Commands.add("login", (email, password) => {
  const userEmail = email ?? "thruthesky@gmail.com";
  const userPass = password ?? "12345a";

  cy.request(
    "POST",
    `/?route=user.login&reload=true&email=${userEmail}&password=${userPass}`
  )
    .its("body")
    .as("currentUser");

  cy.get("@currentUser").then((user) => {
    console.log(user.response.sessionId);
    cy.setCookie("sessionId", user.response.sessionId);
  });
});
