<?php

namespace App\Controllers;

use App\Libraries\Library;
use App\Models\Bidang;
use App\Models\JenisMitra;
use App\Models\Kerma;
use App\Models\Mitra;
use App\Models\Models;
use App\Models\RuangLingkup;
use App\Models\Tingkat;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $library;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url', 'number', 'query_helper', 'global_helper'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->helpers = [];

        date_default_timezone_set('Asia/Kolkata'); // Added user timezone
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();

        $this->library = new Library();

        $this->mTingkat = new Tingkat();
        $this->mJenisMitra = new JenisMitra();
        $this->mMitra = new Mitra();
        $this->mModels = new Models();
        $this->mBidang = new Bidang();
        $this->mRuangLingkup = new RuangLingkup();
        $this->mKerma = new Kerma();

        // E.g.: $this->session = \Config\Services::session();
    }
}
