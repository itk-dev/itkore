<?php

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Drupal\DrupalExtension\Context\DrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Drupal\Core\Database\Database;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements SnippetAcceptingContext {

  protected $dateFormat = 'Y-m-d H:i:s';

  /**
   * Initializes context.
   *
   * Every scenario gets its own context instance.
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct() {
    // Drupal database time format
    date_default_timezone_set('Etc/UTC');
  }

  // USER MANAGEMENT

  /**
   * Log out
   *
   * @When I log out
   */
  public function iLogOut() {
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/user/logout'));
  }

  /**
   * Assert that the user is not logged in.
   *
   * @Then I should not/NOT be logged in
   */
  public function assertNotLoggedIn() {
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/admin'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('403');
  }

  /**
   * Asserts that a users can not be edited
   *
   * @Then I should not/NOT be able to edit users
   */
  public function assertNotEditUser() {
    // Create user.
    $user = (object) array(
      'name' => $this->getRandom()->name(8),
      'pass' => $this->getRandom()->name(16),
    );
    $user->mail = "{$user->name}@example.com";
    $this->userCreate($user);

    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/user/' . $user->uid . '/edit'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('403');
  }

  /**
   * Asserts that a users can not be deleted
   *
   * @Then I should not/NOT be able to delete users
   */
  public function assertNotDeleteUser() {
    // Create user.
    $user = (object) array(
      'name' => $this->getRandom()->name(8),
      'pass' => $this->getRandom()->name(16),
    );
    $user->mail = "{$user->name}@example.com";
    $this->userCreate($user);

    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/user/' . $user->uid . '/cancel'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('403');
  }

  /**
   * Asserts that a users can not be created
   *
   * @Then I should not/NOT be able to create users
   */
  public function assertNotCreateUser() {
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/admin/people/create'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('403');
  }

  /**
   * Asserts that a users can not be edited
   *
   * @Then I should be able to edit users
   */
  public function assertEditUser() {
    // Create user.
    $user = (object) array(
      'name' => $this->getRandom()->name(8),
      'pass' => $this->getRandom()->name(16),
    );
    $user->mail = "{$user->name}@example.com";
    $this->userCreate($user);

    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/user/' . $user->uid . '/edit'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('200');
  }

  /**
   * Asserts that a users can not be deleted
   *
   * @Then I should be able to delete users
   */
  public function assertDeleteUser() {
    // Create user.
    $user = (object) array(
      'name' => $this->getRandom()->name(8),
      'pass' => $this->getRandom()->name(16),
    );
    $user->mail = "{$user->name}@example.com";
    $this->userCreate($user);

    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/user/' . $user->uid . '/cancel'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('200');
  }

  /**
   * Asserts that a users can not be created
   *
   * @Then I should be able to create users
   */
  public function assertCreateUser() {
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/admin/people/create'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('200');
  }


  // EDIT

  /**
   * Asserts that a given content type is NOT editable.
   *
   * @Then I should not/NOT be able to edit a/an :type( content)
   */
  public function assertNotEditNodeOfType($type) {
    $node = (object) array(
      'type' => $type,
      'title' => $this->getRandom()->string(20),
      'body' => $this->getRandom()->string(255),
      );
    $saved = $this->nodeCreate($node);
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/node/' . $saved->nid . '/edit'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('403');
  }

  /**
   * Asserts that the current user can edit own content
   *
   * @Then I should be able to edit my :type( content)
   */
  public function assertEditMyNodeOfType($type) {
    if (!isset($this->user->uid)) {
      throw new \Exception(sprintf('There is no current logged in user to create a node for.'));
    }
    $node = (object) array(
      'type' => $type,
      'title' => $this->getRandom()->string(20),
      'body' => $this->getRandom()->string(255),
      'uid' => $this->user->uid,
    );
    $saved = $this->nodeCreate($node);
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/node/' . $saved->nid . '/edit'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('200');
  }

  /**
   * Asserts that a given content type is editable.
   *
   * @override @Then I should be able to edit a/an :type( content)
   */
  public function assertEditNodeOfType($type) {
    $node = (object) array(
      'type' => $type,
      'title' => $this->getRandom()->string(20),
      'body' => $this->getRandom()->string(255),
    );
    $saved = $this->nodeCreate($node);
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/node/' . $saved->nid . '/edit'));
    // Test status.
    $this->assertSession()->statusCodeEquals('200');
  }

  /**
   * Asserts that the current user can NOT edit own content
   *
   * @Then I should not be able to edit my :type( content)
   */
  public function assertNotEditMyNodeOfType($type) {
    if (!isset($this->user->uid)) {
      throw new \Exception(sprintf('There is no current logged in user to create a node for.'));
    }
    $node = (object) array(
      'type' => $type,
      'title' => $this->getRandom()->string(20),
      'body' => $this->getRandom()->string(255),
      'uid' => $this->user->uid,
    );
    $saved = $this->nodeCreate($node);
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/node/' . $saved->nid . '/edit'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('403');
  }



  // DELETE

  /**
   * Asserts that a given content type can be deleted.
   *
   * @Then I should be able to delete a/an :type( content)
   */
  public function assertDeleteNodeOfType($type) {
    $node = (object) array(
      'type' => $type,
      'title' => $this->getRandom()->string(20),
      'body' => $this->getRandom()->string(255),
    );
    $saved = $this->nodeCreate($node);
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/node/' . $saved->nid . '/delete'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('200');
  }

  /**
   * Asserts that a given content type can NOT be deleted.
   *
   * @Then I should not/NOT be able to delete a/an :type( content)
   */
  public function assertNotDeleteNodeOfType($type) {
    $node = (object) array(
      'type' => $type,
      'title' => $this->getRandom()->string(20),
      'body' => $this->getRandom()->string(255),
    );
    $saved = $this->nodeCreate($node);
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/node/' . $saved->nid . '/delete'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('403');
  }

  /**
   * Asserts that the current user can delete own content
   *
   * @Then I should be able to delete my :type( content)
   */
  public function deleteMyNode($type) {
    if (!isset($this->user->uid)) {
      throw new \Exception(sprintf('There is no current logged in user to create a node for.'));
    }
    $node = (object) array(
      'type' => $type,
      'title' => $this->getRandom()->string(20),
      'body' => $this->getRandom()->string(255),
      'uid' => $this->user->uid,
    );
    $saved = $this->nodeCreate($node);
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/node/' . $saved->nid . '/delete'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('200');
  }

  /**
   * Asserts that the current user can NOT delete own content
   *
   * @Then I should not be able to delete my :type( content)
   */
  public function assertNotDeleteMyNodeOfType($type) {
    if (!isset($this->user->uid)) {
      throw new \Exception(sprintf('There is no current logged in user to create a node for.'));
    }
    $node = (object) array(
      'type' => $type,
      'title' => $this->getRandom()->string(20),
      'body' => $this->getRandom()->string(255),
      'uid' => $this->user->uid,
    );
    $saved = $this->nodeCreate($node);
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/node/' . $saved->nid . '/delete'));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('403');
  }


  // CREATE

  /**
   * Asserts that a given content type can be created.
   *
   * @Then I should be able to create a/an :type( content)
   */
  public function assertCreateNodeOfType($type) {
    $node = (object) array(
      'type' => $type,
      'title' => $this->getRandom()->string(20),
      'body' => $this->getRandom()->string(255),
    );
    $saved = $this->nodeCreate($node);
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/node/add/'. $type));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('200');
  }

  /**
   * Asserts that a given content type can NOT be created.
   *
   * @Then I should not/NOT be able to create a/an :type( content)
   */
  public function assertNotCreateNodeOfType($type) {
    $node = (object) array(
      'type' => $type,
      'title' => $this->getRandom()->string(20),
      'body' => $this->getRandom()->string(255),
    );
    $saved = $this->nodeCreate($node);
    // Set internal browser on the node edit page.
    $this->getSession()->visit($this->locatePath('/node/add/'. $type));
    // Test status is 403 Forbidden.
    $this->assertSession()->statusCodeEquals('403');
  }


  // DATES MANAGEMENT

  /**
   * Overide to fix created date not being set correctly.
   *
   * Creates content of a given type provided in the form:
   * | title    | author     | status | created           |
   * | My title | Joe Editor | 1      | 2014-10-17 8:00am |
   * | ...      | ...        | ...    | ...               |
   *
   * @override Given :type content:
   */
  public function createNodes($type, TableNode $nodesTable) {
    foreach ($nodesTable->getHash() as $nodeHash) {
      $node = (object) $nodeHash;
      $node->type = $type;
      if(isset($node->created)) {
        $timestamp = strtotime($node->created);
        if(!$timestamp) {
          throw new \InvalidArgumentException(sprintf(
            "Can't resolve '%s' into a valid datetime value",
            $node->created
          ));
        } else {
          $node->created = $timestamp;
        }
      }
      $node = $this->nodeCreate($node);
    }
  }


  /**
   * Transforms relative date statements compatible with strtotime().
   * Example: "date 2 days ago" might return "2013-10-10" if its currently
   * the 12th of October 2013. Customize through {@link setDateFormat()}.
   *
   * @Transform /^(?:the|a) date (?<date>.*)$/
   */
  public function castRelativeToAbsoluteDate($val) {
    $timestamp = strtotime($val);
    if(!$timestamp) {
      throw new \InvalidArgumentException(sprintf(
        "Can't resolve '%s' into a valid datetime value",
        $val
      ));
    }
    return date($this->dateFormat, $timestamp);
  }

  public function getDateFormat() {
    return $this->dateFormat;
  }

  public function setDateFormat($format) {
    $this->dateFormat = $format;
  }

  /**
   * Dump html output to file for debug reference
   *
   * From https://gist.github.com/jonathanfranks/0599e5f45a839ccb8248
   *
   * @AfterScenario
   */
  public function dumpHtmlAfterFailedStep(AfterScenarioScope $scope) {
    if (99 === $scope->getTestResult()->getResultCode()) {
      $filename = $scope->getFeature()->getFile() . '-' . $scope->getScenario()->getLine();
      $this->dumpHtml($filename);
    }
  }

  private function dumpHtml($scenarioFileName) {
    $filePieces = explode('/', $scenarioFileName);

    $fileName = array_pop($filePieces) . '-' . time() . '.html';
    $fileName = array_pop($filePieces). '-' .$fileName;
    array_pop($filePieces);

    $html_dump_path = implode('/', $filePieces) . '/failures';
    if (!file_exists($html_dump_path)) {
      mkdir($html_dump_path);
    }

    $html = $this->getSession()->getPage()->getContent();
    $location = $this->getSession()->getCurrentUrl();
    $headers = print_r($this->getSession()->getResponseHeaders(), true);

    $dump = $location.PHP_EOL.'---'.PHP_EOL.$headers.PHP_EOL.'---'.PHP_EOL.$html;

    $htmlCapturePath = $html_dump_path . '/' . $fileName;
    file_put_contents($htmlCapturePath, $dump);

    $message = "\nHTML available at: " . $htmlCapturePath;
    print $message . PHP_EOL;

  }
}
