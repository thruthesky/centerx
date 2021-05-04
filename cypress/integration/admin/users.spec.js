describe("Users", function () {
  beforeEach(() => {
    cy.login();
  });

  it("Checks admin users page", function () {
    cy.visit("?p=admin.index&w=user/admin-user-list");

    cy.get('[data-cy="admin-user-list"]').should("exist");

    /// test column visibility
    cy.get('[data-cy="gender-col-header"]').should("not.exist");
    cy.get('[data-cy="gender-option"]').check({ force: true });
    cy.get('[data-cy="gender-col-header"]').should("exist");
    cy.get('[data-cy="gender-option"]').uncheck({ force: true });
    cy.get('[data-cy="gender-col-header"]').should("not.exist");

    /// edit user info
    cy.get('[data-cy="user-info-edit-button"]').first().click();
    cy.url().should('include', 'admin-user-edit');
    cy.get('[data-cy="user-edit-form-idx"]').should('be.disabled'); // IDX field should be disabled and not editable

    /// edit nickname
    const newNickname = "Test Nickname";
    cy.get('[data-cy="user-edit-form-nickname"]').clear().type(newNickname);
    cy.get('[data-cy="user-edit-form-submit"]').click();
    cy.get('[data-cy="user-edit-form-nickname"]').should('have.value', newNickname);
  });
});

