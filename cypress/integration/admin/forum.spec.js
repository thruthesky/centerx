describe("Forum", function () {
  beforeEach(() => {
    cy.login();
  });

  it("tests forum settings crud", function () {
    cy.visit("/?p=admin.index&w=category/admin-category-list");
    cy.viewport(2048, 800)

    const testCategory = 'aa_test_category';
    const testCategoryTitle = 'Test Category';
    const testCategoryDescription = 'This is test category description';

    const testCategorySubcategories = 'apple,banana,cherry';
    const testCategoryPostCreatePoint = 20;
    const testCategoryPostDeletePoint = -10;
    const testCategoryCommentCreatePoint = 20;
    const testCategoryCommentDeletePoint = -10

    /// create new category
    cy.getElement('category-input').should("exist").type(`${testCategory}`);
    cy.get('button[type="submit"]').should("exist").click();

    /// edit test category 
    cy.getElement(testCategory).should('exist');
    cy.getElement('category-settings-form').should('exist');
    cy.getElement('category-settings-form-title').clear().type(testCategoryTitle); // title
    cy.getElement('category-settings-form-description').clear().type(testCategoryDescription); // description

    cy.getElement('category-settings-form-subcategories').clear().type(testCategorySubcategories); // subcategories
    cy.getElement('category-settings-form-post-create-point').clear().type(testCategoryPostCreatePoint); //  post create point
    cy.getElement('category-settings-form-post-delete-point').clear().type(testCategoryPostDeletePoint); // post delete point
    cy.getElement('category-settings-form-comment-create-point').clear().type(testCategoryCommentCreatePoint); // comment create point
    cy.getElement('category-settings-form-comment-delete-point').clear().type(testCategoryCommentDeletePoint); // comment delete point
    cy.getElement('category-settings-form-submit').click();

    /// check if correct
    cy.getElement('category-' + testCategory + '-title').should('have.text', testCategoryTitle); // title
    cy.getElement('category-' + testCategory + '-description').should('have.text', testCategoryDescription) // description
    cy.getElement('category-settings-form-subcategories').should('have.value', testCategorySubcategories); // subcategories
    cy.getElement('category-settings-form-post-create-point').should('have.value', testCategoryPostCreatePoint); // post create point
    cy.getElement('category-settings-form-post-delete-point').should('have.value', testCategoryPostDeletePoint);  // post delete point
    cy.getElement('category-settings-form-comment-create-point').should('have.value', testCategoryCommentCreatePoint); // comment create point
    cy.getElement('category-settings-form-comment-delete-point').should('have.value', testCategoryCommentDeletePoint); // comment delete point

    // /// delete `testCategory`
    // cy.getElement(testCategory + '-delete').click();
    // cy.on('window:confirm', () => true); /// react to confirm
    // cy.getElement(testCategory).should('not.exist');
  });
});
