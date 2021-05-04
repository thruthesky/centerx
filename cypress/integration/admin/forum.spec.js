describe("Forum", function () {
  beforeEach(() => {
    cy.login();
  });

  it("tests forum settings crud", function () {
    cy.visit("/?p=admin.index&w=category/admin-category-list");

    const testCategory = 'aa_test_category';
    const testCategoryTitle = 'Test Category';
    const testCategoryDescription = 'This is test category description';

    /// create new category
    cy.get('[data-cy="category-input"]').should("exist").type(`${testCategory}`);
    cy.get('button[type="submit"]').should("exist").click();

    /// edit test category title and description
    cy.get(`[data-cy="${testCategory}"]`).should('exist');
    cy.get(`[data-cy="category-settings-form"]`).should('exist');
    cy.get(`[data-cy="category-settings-form-title"]`).type(testCategoryTitle);
    cy.get(`[data-cy="category-settings-form-description"]`).type(testCategoryDescription);
    cy.get('[data-cy="category-settings-form-submit"]').click();

    /// check if correct
    cy.get(`[data-cy="category-${testCategory}-title"]`).should('have.text', testCategoryTitle);
    cy.get(`[data-cy="category-${testCategory}-description"]`).should('have.text', testCategoryDescription)

    /// delete `testCategory`
    cy.get(`[data-cy="${testCategory}-delete"]`).click();
    cy.on('window:confirm', () => true); /// react to confirm
    cy.get(`[data-cy="${testCategory}"]`).should('not.exist');
  });
});
