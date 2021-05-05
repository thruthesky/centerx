describe("Settings", function () {
  beforeEach(() => {
    cy.login();
  });

  it("tests settings crud", function () {
    cy.visit("?p=admin.index&w=setting/admin-setting");
  });
});
