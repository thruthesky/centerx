/// <reference types="cypress" />

describe("Users", function () {
  beforeEach(() => {
    cy.loginOrRegister();
  });

  it("Checks admin users page", function () {
    cy.viewport(2048, 1024);
    cy.visit("?p=admin.index&w=user/admin-user-list");

    // cy.getElement('admin-user-list"]').should("exist");
    cy.getElement("admin-user-list").should("exist");

    /// test column visibility
    cy.getElement("gender-col-header").should("not.exist");
    cy.getElement("gender-option").check({ force: true });
    cy.getElement("gender-col-header").should("exist");
    cy.getElement("gender-option").uncheck({ force: true });
    cy.getElement("gender-col-header").should("not.exist");

    /// edit user info
    cy.getElement("user-info-edit-button").first().click();
    cy.url().should("include", "admin-user-edit");
    cy.getElement("user-edit-form-idx").should("be.disabled"); // IDX field should be disabled and not editable

    /// edit
    const newNickname = "Test Nickname";
    const newNumber = "+639654111111";
    cy.getElement("user-edit-nickname").clear().type(newNickname); /// nickname
    cy.getElement("user-edit-phone-number").clear().type(newNumber); /// nickname
    cy.getElement("user-edit-gender-select").select("M"); /// gender

    cy.getElement("user-edit-submit").click();
    cy.getElement("user-edit-nickname").should("have.value", newNickname);
    cy.getElement("user-edit-phone-number").should("have.value", newNumber);
    cy.getElement("user-edit-gender-select").should("have.value", "M");
  });
});
