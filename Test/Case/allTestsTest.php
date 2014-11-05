<?php
/*
 * Custom test suite to execute all tests
 */

class AllTestsTest extends PHPUnit_Framework_TestSuite {

    public static function suite() {

        $path = APP . 'Test' . DS . 'Case' . DS;

        $suite = new CakeTestSuite('All tests');
        $suite->addTestDirectory(TESTS . 'Case' . DS . 'Model');
        $suite->addTestDirectory(TESTS . 'Case' . DS . 'Controller');

/*        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'AdminsControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'CategoriesControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'SubjectsControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'ClassesControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'AssignmentsControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'AnswersControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'AlertsControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'AssignmentTypesControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'EmployeesControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'LearningStylesControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'LicensesControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'NotesControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'QuestionsControllerTest.php');
        $suite->addTestFile(TESTS . 'Case' . DS . 'Controller' . DS . 'SchoolsControllerTest.php');
  */
        return $suite;

    }

}
