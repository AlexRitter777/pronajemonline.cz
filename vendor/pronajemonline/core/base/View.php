<?php

namespace pronajem\base;
use DI\Attribute\Inject;
use pronajem\App;



class View
{

    /**
     * @var string $view The name of the view file to be rendered. Specifies which file within
     * the controller's view directory should be used.
     */
    public $view;

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
     * @param string|false $layout The layout file to be used. If set to false, no layout will be used. If not specified,
     *                             a default layout is used. This parameter allows for specific or generic layouts to be applied to the view.
     * @param string $view The name of the view file to be rendered within the specified layout.
     * @param array $meta An associative array containing meta information ('title', 'desc', 'keywords') for the page.
     */
    public function __construct($meta, $layout = '', $view = ''){
        $this->view = $view;
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

            $viewFile = '';
            
            $viewFile = APP . "/views/{$this->view}.php";

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




}