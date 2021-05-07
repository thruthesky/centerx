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
 * Login or register via request.
 *
 * @note only use this when not testing login page.
 */
Cypress.Commands.add("loginOrRegister", (email, password) => {
  const userEmail = email ?? "thruthesky@gmail.com";
  const userPass = password ?? "12345a";

  cy.request(
    "POST",
    `/?route=user.loginOrRegister&email=${userEmail}&password=${userPass}`
  )
    .its("body")
    .as("currentUser");

  cy.get("@currentUser").then((user) => {
    cy.setCookie("sessionId", user.response.sessionId);
  });
});

Cypress.Commands.add("getElement", (ID) => {
  return cy.get(`[data-cy="${ID}"]`);
});
