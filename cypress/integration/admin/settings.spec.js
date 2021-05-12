/// <reference types="cypress" />

describe("Settings", function () {
  beforeEach(() => {
    cy.loginOrRegister();
  });

  it("tests settings crud", function () {
    cy.visit("?p=admin.index&w=setting/admin-setting");
  });
});
