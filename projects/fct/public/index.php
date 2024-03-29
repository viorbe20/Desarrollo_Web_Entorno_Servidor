<?php
require_once('..\app\Config\constantes.php');
require_once('..\vendor\autoload.php');

use App\Core\Router;
use App\Controllers\DefaultController;
use App\Controllers\StudentController;
use App\Controllers\CompanyController;

session_start();

//Siempre se abre sesión como invitado
if (!isset($_SESSION['user']['profile'])) {
    $_SESSION['user']['profile'] = "guest";
    $_SESSION['user']['name'] = "invitado";
    $_SESSION['user']['status'] = "logout";
}

$router = new Router();

$router->add(array(
    'name' => 'add assignments',
    'path' => '/^\/test$/',
    'action' => [StudentController::class, 'testAction'],
    'auth' => ["admin, user"]
));

//Assignments

$router->add(array(
    'name' => 'add assignments',
    'path' => '/^\/calls\/add_assignment$/',
    'action' => [DefaultController::class, 'addAssignmentAction'],
    'auth' => ["admin, user"]
));

$router->add(array(
    'name' => 'show assignments',
    'path' => '/^\/calls\/call_assignments\/\d{1,3}$/',
    'action' => [DefaultController::class, 'showAssignmentsAction'],
    'auth' => ["admin, user"]
));

$router->add(array(
    'name' => 'assignments table',
    'path' => '/^\/assignments_table$/',
    'action' => [DefaultController::class, 'getAssignmentsTableAction'],
    'auth' => ["admin, user"]
));

//CALLS

$router->add(array(
    'name' => 'calls table',
    'path' => '/^\/calls_table$/',
    'action' => [DefaultController::class, 'getCallsTableAction'],
    'auth' => ["admin, user"]
));

$router->add(array(
    'name' => 'calls',
    'path' => '/^\/calls$/',
    'action' => [DefaultController::class, 'callsAction'],
    'auth' => ["admin, user"]
));

//STUDENTS

$router->add(array(
    'name' => 'students table',
    'path' => '/^\/students_by_group\/\d{1,3}_\d{1,3}_\d{1,3}$/',
    'action' => [StudentController::class, 'getStudentsByGroupAction'],
    'auth' => ["admin, user"]
));

$router->add(array(
    'name' => 'students table',
    'path' => '/^\/students_table$/',
    'action' => [StudentController::class, 'getStudentsTableAction'],
    'auth' => ["admin, user"]
));

$router->add(array(
    'name' => 'students',
    'path' => '/^\/students$/',
    'action' => [StudentController::class, 'addStudentsAction'],
    'auth' => ["admin, user"]
));

//EMPLOYEES
$router->add(array(
    'name' => 'employees',
    'path' => '/^\/companies\/company_employees\/\d{1,3}$/',
    'action' => [DefaultController::class, 'companyEmployeesAction'],
    'auth' => ["admin, user"]
));

//Companies

$router->add(array(
    'name'=>'create company',
    'path'=>'/^\/companies\/create_company$/',
    'action'=>[CompanyController::class, 'createCompanyAction'],
    'auth'=>["admin, user"]
));
$router->add(array(
    'name' => 'delete company',
    'path' => '/^\/companies\/delete_company\/\d{1,3}$/',
    'action' => [CompanyController::class, 'deleteCompanyAction'],
    'auth' => ["admin, user"]
));

$router->add(array(
    'name' => 'add company',
    'path' => '/^\/companies\/add_company$/',
    'action' => [CompanyController::class, 'addCompanyAction'],
    'auth' => ["admin, user"]
));

$router->add(array(
    'name' => 'companies',
    'path' => '/^\/companies$/',
    'action' => [CompanyController::class, 'companiesAction'],
    'auth' => ["admin, user"]
));

$router->add(array(
    'name' => 'companies table',
    'path' => '/^\/companies_table$/',
    'action' => [CompanyController::class, 'getCompaniesTableAction'],
    'auth' => ["admin, user"]
));

$router->add(array(
    'name' => 'home',
    'path' => '/^\/home$/',
    'action' => [DefaultController::class, 'indexAction'],
    'auth' => ["admin, user"]
));

$router->add(array(
    'name' => 'home',
    'path' => '/^\/logout$/',
    'action' => [DefaultController::class, 'logoutAction'],
    'auth' => ["admin, user"]
));


$request = str_replace(DIRBASEURL, '', $_SERVER['REQUEST_URI']);
$route = $router->matchs($request);

if ($route) {
    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName;
    $controller->$actionName($request);
} else {
    echo "No route matched";
}
