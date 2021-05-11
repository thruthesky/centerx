/// <reference types="cypress" />

describe("Login", function () {
  it("logins with the login form", function () {
    cy.visit('/');

    cy.getElement("login-button").click();

    cy.getElement("login-form").should("exist");

    cy.getElement("email-input").type("thruthesky@gmail.com");
    cy.getElement("password-input").type("12345a");

    cy.getElement("submit-button").click();
    cy.getElement("logout-button").should("exist");
    cy.getElement("login-button").should("not.exist");
    cy.getElement("register-button").should("not.exist");
  });
});
