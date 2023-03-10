<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Dashboard::index');

$routes->get('/', 'Auth::index', ['filter' => 'beforeLogin']);
$routes->group('auth', ['filter' => 'beforeLogin'], function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->post('login', 'Auth::login', ['as' => 'auth.login']);
});

$routes->group('/dashboard', ['filter' => 'afterLogin'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('grafik', 'Dashboard::grafikDashboard');
});


$routes->group('/bidang', ['filter' => 'afterLogin'], function ($routes) {
    $routes->get('', 'Bidang::index');
    $routes->post('saveBidang', 'Bidang::saveBidang', ['as' => 'save.bidang']);
});


$routes->group('/ruang-lingkup', ['filter' => 'afterLogin'], function ($routes) {
    $routes->get('', 'RuangLingkup::index');
    $routes->post('saveRuangLingkup', 'RuangLingkup::saveRuangLingkup', ['as' => 'save.ruangLingkup']);
});

$routes->group('mitra', ['filter' => 'afterLogin'], function ($routes) {
    $routes->get('', 'Mitra::index');
    $routes->get('jenis', 'Mitra::jenisMitra');
    $routes->get('tingkat', 'Mitra::tingkat');
    $routes->post('saveMitra', 'Mitra::saveMitra', ['as' => 'save.mitra']);
    $routes->post('saveTingkat', 'Mitra::saveTingkat', ['as' => 'save.tingkat']);
    $routes->post('saveJenis', 'Mitra::saveJenisMitra', ['as' => 'save.jenis']);
    $routes->post('importExcel', 'Mitra::uploadExcelMitra');
});

$routes->group('kerma', ['filter' => 'afterLogin'], function ($routes) {
    $routes->get('/', 'Kerma::index');
    $routes->get('rekap', 'Kerma::rekap');
    $routes->post('saveKerma', 'Kerma::saveKerma', ['as' => 'save.kerma']);
    $routes->post('lapAkreditas', 'Kerma::lapAkreditas', ['as' => 'kerma-cetak.akreditasi']);
    $routes->post('lapLldikti', 'Kerma::lapLldikti', ['as' => 'kerma-cetak.lldikti']);
    $routes->post('lapMatriks', 'Kerma::lapMatriks', ['as' => 'kerma-cetak.matriks']);
    $routes->post('importExcel', 'Kerma::uploadExcelKerma');
});

$routes->post('/modal/(:any)', 'Modal::index', ['filter' => 'afterLogin']);
$routes->post('datatable', 'Datatable::index', ['filter' => 'afterLogin']);
$routes->post('server-side', 'ServerSide::index', ['filter' => 'afterLogin']);
$routes->post('select2/(:any)', 'Select2::index', ['filter' => 'afterLogin']);
$routes->post('delete', 'Delete::index', ['filter' => 'afterLogin']);
$routes->get('logout', 'Auth::logout');

$routes->get('tools-kerma', 'Tools::index');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
