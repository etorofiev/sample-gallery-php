<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Xandros15\SlimPagination\Pagination;

// Let requests for static files pass through
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER['REQUEST_URI'])) {
    return false;
}

require 'vendor/autoload.php';

// Do basic configuration and create an app instance to use
$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();

$config = [
    'settings' => [
        'displayErrorDetails' => getenv('DISPLAY_ERRORS'),
        'db' => [
            'host' => getenv('DB_HOST'),
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASSWORD'),
            'dbname' => getenv('DB_NAME'),
        ]
    ]
];

$app = new \Slim\App($config);

$container = $app->getContainer();

// Register services
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('sample-gallery-php');
    $file_handler = new \Monolog\Handler\StreamHandler('./logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['view'] = new \Slim\Views\PhpRenderer('./templates/');

// Register application routes
////TODO extract in a separate router
$app->get('/', function (Request $request, Response $response) {
    $this->logger->addInfo('Home page visit');
    $list_action = new \SampleGalleryPhp\Actions\ListAction($this->db);
    $latest = $list_action->getLatest();
    $response = $this->view->render($response, 'home.php', ['latest' => $latest]);
    return $response;
});

$app->get('/gallery[/page/{page}]', function (Request $request, Response $response, $args) {
    $this->logger->addInfo('Gallery page visit');
    $list_action = new \SampleGalleryPhp\Actions\ListAction($this->db);

    if (empty($args['limit'])) {
        $args['limit'] = 6;
    }
    if (empty($args['page'])) {
        $args['page'] = 1;
    }

    $images = $list_action->getAll($args['page'], $args['limit']);
    $total = $list_action->getTotal();

    $pagination = new Pagination($request, $this->get('router'),[
        Pagination::OPT_TOTAL => $total,
        Pagination::OPT_PER_PAGE => $args['limit'],
        Pagination::OPT_PARAM_TYPE => \Xandros15\SlimPagination\PageList::PAGE_ATTRIBUTE
    ]);
    $paginationString = $this->view->fetch('pagination.php', ['pagination' => $pagination]);

    $response = $this->view->render($response, 'gallery.php', ['images' => $images, 'pagination' => $paginationString]);
    return $response;
})->setName('gallery');

$app->get('/gallery/{id}', function (Request $request, Response $response, $args) {
    $this->logger->addInfo('Image details page visit');
    $list_action = new \SampleGalleryPhp\Actions\ListAction($this->db);
    $image = $list_action->get($args['id']);
    $response = $this->view->render($response, 'details.php', ['image' => $image]);
    return $response;
});

$app->post('/search', function (Request $request, Response $response) {
    $this->logger->addInfo('Search for images request');
    $list_action = new \SampleGalleryPhp\Actions\ListAction($this->db);
    $images = $list_action->search($request->getParam('search_term'));
    $response = $this->view->render($response, 'gallery.php', ['images' => $images, 'pagination' => '']); ////TODO implement pagination in search
    return $response;
});

$app->get('/upload', function (Request $request, Response $response) {
    $this->logger->addInfo('Upload image page visit');
    $response = $this->view->render($response, 'upload.php');
    return $response;
});

$app->post('/upload-image', function (Request $request, Response $response) {
    $this->logger->addInfo('Upload image request');
    $files = $request->getUploadedFiles();
    $params = $request->getParams(['image_name', 'image_description']);
    $upload_action = new \SampleGalleryPhp\Actions\UploadAction($this->db);
    $upload_action->save($files, $params);
    $response = $response->withHeader('Location', '/gallery')->withStatus(303);
    return $response;
});

// This one should be DELETE instead of GET actually
$app->get('/gallery/{id}/delete', function (Request $request, Response $response, $args) {
    $this->logger->addInfo('Delete image request');
    $delete_action = new \SampleGalleryPhp\Actions\DeleteAction($this->db);
    $delete_action->delete($args['id']);
    $response = $response->withHeader('Location', '/gallery')->withStatus(303);
    return $response;
});

$app->run();
