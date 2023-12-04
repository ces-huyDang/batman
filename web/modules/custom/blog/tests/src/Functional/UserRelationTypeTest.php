<?php

namespace Drupal\Tests\blog\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test the User Relation Type config entity.
 *
 * @group user_relation
 */
class UserRelationTypeTest extends BrowserTestBase
{

    /**
     * {@inheritdoc}
     */
    protected $defaultTheme = 'stark';

    /**
     * Modules to enable.
     *
     * @var array
     */
    protected static $modules = ['user_relation'];

    /**
     * Various functional test of the User Relation module.
     *
     * 1) Verify that we can manage entities through the user interface.
     *
     * 2) Create User > Consultant.
     *
     * 3) Verify that the entity we add can be re-edited.
     *
     * 4) Verify that the label is shown in the list.
     */
    public function testUserRelationType()
    {
        $assert = $this->assertSession();

        $account = $this->drupalCreateUser(['administer user relation types']);
        $this->drupalLogin($account);

        // 1) Test the UI page.
        $this->drupalGet('admin/structure/user-relation');
        $this->assertSession()->statusCodeEquals(200);  
        $this->assertSession()->pageTextContains('operations');

        // 2) Create a User Relation Type entity.
        $this->drupalGet('admin/structure/user-relation/add');
        $assert->statusCodeEquals(200);

        // $this->clickLink('Add user relation type');
        $machine_name = 'client__consultant';
        $label = 'Client > Consultant';
        $reverse_label = 'Consultant > Client';

        $this->submitForm(
            [
            'id' => $machine_name,
            'label' => $label,
            'reverse_label' => $reverse_label,
            'directional' => false,
            'source' => 'role:authenticated',
            'target' => 'role:authenticated',
            ],
            'Save'
        );

        $assert->pageTextContains('The ' . $machine_name . ' relation type has been created.');

        // 3) Verify the entity we created.
        $this->drupalGet('/admin/structure/user-relation/manage/' . $machine_name);
        $assert->fieldExists('id');

        // 4) Verify label is shown in the list.
        $this->drupalGet('admin/structure/user-relation');
        $assert->pageTextContains('Client > Consultant');

    }

}
