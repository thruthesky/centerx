/// <reference types="cypress" />

describe("Page checking", function () {
  beforeEach(() => {
    cy.loginOrRegister();
  });

  it("Checks the admin dashboard content", function () {
    cy.visit("/");
    cy.getElement("home-admin-button").click();
    cy.getElement("admin-dashboard-page").should("exist");
    cy.getElement("admin-top-user-by-points-widget").should("exist");
    cy.getElement("admin-post-list-recent-summary-widget").should("exist");
    cy.getElement("admin-point-setting-summary-widget").should("exist");
    cy.getElement("admin-post-list-summary-widget").should("exist");
    cy.getElement("admin-post-list-top-comment-widget").should("exist");
    cy.getElement("admin-statistic-graph-widget").should("exist");
  });

  it("Checks admin settings page", function () {
    cy.visit("/?p=admin.index");
    cy.getElement("admin-settings-button").click();
    cy.getElement("admin-settings-page").should("exist");
  });

  it("Checks admin about page", function () {
    cy.visit("/?p=admin.index");
    cy.getElement("admin-about-button").click();
    cy.getElement("admin-upload-image-page").should("exist");
  });

  it("Checks admin point setting page", function () {
    cy.visit("/?p=admin.index");
    cy.getElement("admin-point-setting-button").click();
    cy.getElement("admin-point-setting-page").should("exist");
  });

  it("Checks admin translation page", function () {
    cy.visit("/?p=admin.index");
    cy.getElement("admin-translation-button").click();
    cy.getElement("admin-translation-page").should("exist");
  });

  it("Checks admin point history page", function () {
    cy.visit("/?p=admin.index");
    cy.getElement("admin-point-history-button").click();
    cy.getElement("admin-point-history-page").should("exist");
  });

  it("Checks admin push notification create page", function () {
    cy.visit("/?p=admin.index");
    cy.getElement("admin-push-notification-button").click();
    cy.getElement("push-notification-create-page").should("exist");
  });
});
