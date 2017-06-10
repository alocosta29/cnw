<?php
App::uses('RolesUser', 'Model');

/**
 * RolesUser Test Case
 *
 */
class RolesUserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.roles_user',
		'app.role',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RolesUser = ClassRegistry::init('RolesUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RolesUser);

		parent::tearDown();
	}

}
