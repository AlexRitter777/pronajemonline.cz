<?php

namespace pronajem\base;
use pronajem\App;


/**
 * The View class is responsible for rendering the HTML content of the application.
 * It handles the inclusion of view files based on the controller's actions and the
 * application's routing, applying the specified layout and incorporating the necessary
 * view components. This class facilitates the separation of the application logic from
 * the presentation layer, allowing for dynamic content generation and flexible view management.
 *
 * Properties include routing information, controller and view identification, layout configuration,
 * and data to be displayed, ensuring that all necessary context is available for rendering the page.
 * The class also supports setting meta information for the HTML document, enhancing SEO and user experience.
 */
class View
{

    /**
     * @var array $route Contains routing information such as the current controller and action.
     * Used to construct the path to the view file.
     */
    public $route;

    /**
     * @var string $controller The name of the current controller. Extracted from the route
     * information to help determine the view file path.
     */
    public $controller;

    /**
     * @var string $view The name of the view file to be rendered. Specifies which file within
     * the controller's view directory should be used.
     */
    public $view;

    /**
     * @var string $prefix An optional prefix used in the view file path, typically related to
     * modules or sections of the application.
     */
    public $prefix;

    /**
     * @var array $data An associative array of data that is passed to the view. This data is
     * extracted and made available as variables within the view file.
     */
    public $data = [];

    /**
     * @var array $meta Contains meta information for the HTML document, such as 'title',
     * 'description', and 'keywords'. Used in the <head> section of the layout.
     */
    public $meta = [];

    /**
     * @var string|false $layout Specifies the layout file to be used for rendering the view.
     * If set to false, no layout will be used, allowing for rendering of partial views.
     */
    public $layout;


    /**
     * Initializes a new View object with specific properties.
     *
     * The constructor sets up the view environment based on the provided route information,
     * layout choice, view name, and meta information for the page. It configures the view
     * to use the specified layout unless explicitly set to false, in which case no layout will
     * be used. This allows for flexible rendering options, including full page layouts or
     * partial views.
     *
     * @param array $route The routing information, typically including controller and prefix, used to determine the view path.
     * @param string|false $layout The layout file to be used. If set to false, no layout will be used. If not specified,
     *                             a default layout is used. This parameter allows for specific or generic layouts to be applied to the view.
     * @param string $view The name of the view file to be rendered within the specified layout.
     * @param array $meta An associative array containing meta information ('title', 'desc', 'keywords') for the page.
     */
    public function __construct($route, $meta, $layout = '', $view = ''){
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->view = $view;
        $this->prefix =  $this->checkPrefix($route['prefix']);
        $this->meta = $meta;
        if($layout === false) {
            $this->layout = false;
        }else{
            $this->layout = $layout ?: LAYOUT;
        }

    }


    /**
     * Renders the specified view along with its layout and includes.
     *
     * This method extracts data to be available within the view, then dynamically includes
     * specific files based on the layout configuration, as defined in the application's
     * configuration file (config/params.php). It supports including additional
     * view components like headers, footers, or sidebars according to the 'includes'
     * configuration for the specified layout or the 'default' configuration if specific
     * layout includes are not defined. The primary view content is buffered and injected
     * into the layout file, which is then rendered as the complete page.
     *
     * @param array $data Data to be made available to the view file.
     * @throws \Exception If the view or include files cannot be found, or if the specified layout is missing.
     */
    public function render($data) {
        
            if(is_array($data)) extract($data);

            $includesConfig = App::$app->getProperty('includes');
            $includes = $includesConfig[$this->layout] ?? $includesConfig['default'] ?? [];

            $viewFile = APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php";

            if(is_file($viewFile)){
                ob_start();
                require_once $viewFile;
                $content = ob_get_clean();
            }else{
                throw new \Exception("View {$viewFile} is not found", 500);
            }

            if (!empty($includes)) {
                foreach ($includes as $include) {
                    $includeFile = APP . "/views/Includes/{$include}.php";
                    if (is_file($includeFile)) {
                        ob_start();
                        require_once $includeFile;
                        $$include = ob_get_clean();
                    } else {
                        throw new \Exception("Include file {$includeFile} not found", 500);
                    }
                }
            }

            if(false !== $this->layout) {
                $layoutFile = APP . "/views/layouts/{$this->layout}.php";
                if(is_file($layoutFile)){
                    require_once $layoutFile;
                }else{
                    throw new \Exception("Layout {$this->layout} is not found", 500);
                }
            }


        }


    /**
     * Generates the HTML meta tags for the page based on the meta information provided.
     *
     * This method constructs HTML meta tags for 'title', 'description', and 'keywords'
     * using the values stored in the $meta property of the View object. These tags are
     * essential for SEO and help improve the visibility and ranking of the page in
     * search engine results. The generated meta tags should be included in the <head>
     * section of the HTML document.
     *
     * @return string The constructed HTML meta tags.
     */
    public function getMeta(){
        $output = '<title>' . $this->meta['title'] . '</title>' . PHP_EOL;
        $output .= '<meta name="description" content="' . $this->meta['desc'] . '">' . PHP_EOL;
        $output .= '<meta name="keywords" content="' . $this->meta['keywords'] . '">' . PHP_EOL;
        return $output;
    }

    /**
     * Checks and formats the prefix for the view file path.
     *
     * This method is responsible for ensuring that the prefix used in the view file path
     * is correctly formatted. If the prefix contains backslashes (as used in namespaces),
     * they are replaced with forward slashes to conform to the path structure. This is
     * essential for the correct inclusion of view files, especially when working with
     * modules or subdirectories. If no prefix is provided, or if it does not contain
     * backslashes, the method simply returns an empty string or the unchanged prefix, respectively.
     *
     * @param string $prefix The original prefix as derived from the routing information,
     *                       which may include backslashes from namespace notation.
     * @return string The formatted prefix with backslashes replaced by forward slashes,
     *                or an empty string if no prefix is provided.
     */
    public function checkPrefix($prefix){

        if(!$prefix) return '';

        if(preg_match('#\\\#', $prefix)){
            return preg_replace('#\\\#', '/', $prefix);
        }

    }


}