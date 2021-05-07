describe("Forum", function () {
  beforeEach(() => {
    cy.loginOrRegister();
  });

  it("tests forum settings crud", function () {
    cy.visit("/?p=admin.index&w=category/admin-category-list");
    cy.viewport(2048, 1024)

    const ID = 'aa_test_category';
    const Title = 'Test Category';
    const Description = 'This is test category description';

    const Subcategories = 'apple,banana,cherry';
    const PostCreatePoint = 20;
    const PostDeletePoint = -10;
    const CommentCreatePoint = 20;
    const CommentDeletePoint = -10

    const createHourLimit = 2;
    const createHourLimitCount = 6;
    const createDailyLimitCount = 10;
  
    const postCreateLimit = 321;
    const commentCreateLimit = 123;
    const readLimit = 50;

    const postPerPage = 15;
    const pagesOnNav = 5;

    /// create new category
    cy.getElement('category-input').should("exist").type(`${ID}`);
    cy.get('button[type="submit"]').should("exist").click();

    /// edit test category 
    cy.getElement(ID).should('exist');
    cy.getElement('form').should('exist');
    cy.getElement('form-title').clear().type(Title); // title
    cy.getElement('form-description').clear().type(Description); // description

    cy.getElement('form-subcategories').clear().type(Subcategories); // subcategories
    cy.getElement('form-post-create-point').clear().type(PostCreatePoint); //  post create point
    cy.getElement('form-post-delete-point').clear().type(PostDeletePoint); // post delete point
    cy.getElement('form-comment-create-point').clear().type(CommentCreatePoint); // comment create point
    cy.getElement('form-comment-delete-point').clear().type(CommentDeletePoint); // comment delete point

    cy.getElement('form-create-hour-limit').clear().type(createHourLimit); // create hour limit
    cy.getElement('form-create-hour-limit-count').clear().type(createHourLimitCount); // create hour limit count
    cy.getElement('form-create-daily-limit-count').clear().type(createDailyLimitCount); // create daily limit count
    
    cy.getElement('form-ban-create-on-limit-Y').check(); // ban on writing
    
    cy.getElement('form-post-create-limit').clear().type(postCreateLimit); // post create limit
    cy.getElement('form-comment-create-limit').clear().type(commentCreateLimit); // comment create limit
    cy.getElement('form-read-limit').clear().type(readLimit); // read limit

    cy.getElement('form-return-to-after-post-edit-L').check(); // ban on writing
    
    cy.getElement('form-list-on-view-N').check(); // list on view
    
    cy.getElement('form-post-per-page').clear().type(postPerPage); // post per page
    cy.getElement('form-pages-on-nav').clear().type(pagesOnNav); // pages on nav
    
    cy.getElement('form-mobile-post-list-gallery').check(); // mobile post list view gallery
    
    cy.getElement('form-mobile-post-view-slide').check(); // mobile post view slide

    cy.getElement('form-submit').click(); // submit

    /// check if correct
    cy.getElement('category-' + ID + '-title').should('have.text', Title); // title
    cy.getElement('category-' + ID + '-description').should('have.text', Description) // description
    cy.getElement('form-subcategories').should('have.value', Subcategories); // subcategories
    cy.getElement('form-post-create-point').should('have.value', PostCreatePoint); // post create point
    cy.getElement('form-post-delete-point').should('have.value', PostDeletePoint);  // post delete point
    cy.getElement('form-comment-create-point').should('have.value', CommentCreatePoint); // comment create point
    cy.getElement('form-comment-delete-point').should('have.value', CommentDeletePoint); // comment delete point

    cy.getElement('form-create-hour-limit').should('have.value', createHourLimit); // create hour limit
    cy.getElement('form-create-hour-limit-count').should('have.value', createHourLimitCount); // create hour limit count
    cy.getElement('form-create-daily-limit-count').should('have.value', createDailyLimitCount); // create daily limit count
    
    cy.getElement('form-ban-create-on-limit-Y').should('be.checked') // ban on writing
    cy.getElement('form-ban-create-on-limit-N').should('not.be.checked') // ban on writing
    
    cy.getElement('form-post-create-limit').should('have.value', postCreateLimit); // post create limit
    cy.getElement('form-comment-create-limit').should('have.value', commentCreateLimit); // comment create limit
    cy.getElement('form-read-limit').should('have.value', readLimit); // read limit
    
    cy.getElement('form-return-to-after-post-edit-V').should('not.be.checked') // return to after post edit view
    cy.getElement('form-return-to-after-post-edit-L').should('be.checked') // return to after post edit list

    cy.getElement('form-list-on-view-N').should('be.checked') // list on view no
    cy.getElement('form-list-on-view-Y').should('not.be.checked') // list on view yes

    cy.getElement('form-post-per-page').should('have.value', postPerPage); // post per page
    cy.getElement('form-pages-on-nav').should('have.value', pagesOnNav); // pages on nav


    cy.getElement('form-mobile-post-list-gallery').should('be.checked') // mobile post list view gallery
    cy.getElement('form-mobile-post-list-text').should('not.be.checked') // mobile post list view text
    cy.getElement('form-mobile-post-list-thumbnail').should('not.be.checked') // mobile post list view thumbnail
    
    cy.getElement('form-mobile-post-view-slide').should('be.checked') // mobile post view slide
    cy.getElement('form-mobile-post-view-default').should('not.be.checked') // mobile post view default

    /// delete 
    cy.getElement(ID + '-delete').click();
    cy.on('window:confirm', () => true); /// react to confirm
    cy.getElement(ID).should('not.exist');
  });
});
