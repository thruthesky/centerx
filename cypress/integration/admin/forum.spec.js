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
    cy.getElement('category-input').should("exist").type(`${testCategory}`);
    cy.get('button[type="submit"]').should("exist").click();

    /// edit test category title and description
    cy.getElement(testCategory).should('exist');
    cy.getElement('category-settings-form').should('exist');
    cy.getElement('category-settings-form-title').type(testCategoryTitle);
    cy.getElement('category-settings-form-description').type(testCategoryDescription);
    cy.getElement('category-settings-form-submit').click();

    /// check if correct
    cy.getElement('category-' + testCategory + '-title').should('have.text', testCategoryTitle);
    cy.getElement('category-' + testCategory + '-description').should('have.text', testCategoryDescription)

    /// delete `testCategory`
    cy.getElement(testCategory + '-delete').click();
    cy.on('window:confirm', () => true); /// react to confirm
    cy.getElement(testCategory).should('not.exist');
  });
});
