describe("Users", function () {
    beforeEach(() => {
      cy.login();
    });
  
    it("Checks admin users page", function () {
      cy.visit("?p=admin.index&w=user/admin-user-list");
      cy.get('button[type="submit"]').should("exist");
    });
  });
  