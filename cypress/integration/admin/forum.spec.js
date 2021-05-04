describe("Forum", function () {
  beforeEach(() => {
    cy.login();
  });

  it("Checks admin forum page", function () {
    cy.visit("/?p=admin.index&w=category/admin-category-list");
    cy.get('button[type="submit"]').should("exist");
  });
});
