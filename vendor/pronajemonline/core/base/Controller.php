<?php

namespace pronajem\base;

/**
 * Abstract base controller class that orchestrates the application's response to user input,
 * directing the flow between the model and the view.
 *
 * This foundational class provides the structure for specific controllers within the application.
 * It facilitates the setup and rendering of views, the passing of data to these views, and the
 * management of webpage meta information. Notably, this class does not directly interact with
 * models; instead, its derivatives are responsible for creating and managing specific model instances
 * as needed to handle business logic and data retrieval.
 *
 * Key Features:
 * - Manages the current route's information and determines the appropriate view to render.
 * - Allows for dynamic adjustment of the rendered view and supports passing arbitrary data to the view.
 * - Enables setting of meta information like titles, descriptions, and keywords for enhancing SEO.
 * - Provides flexibility in response formats, including standard HTML views and specialized formats like PDF.
 *
 * Usage Note:
 * Derived controllers should handle specific route actions by interacting with relevant models and
 * preparing data for the view. This design ensures a clear separation of concerns, with controllers
 * acting as intermediaries between the user interface and the application's data logic.
 */
abstract class Controller
{
    /**
     * @var array $route Contains the current route information (controller, action, etc.) used by the controller.
     * This information is typically derived from the URL being processed and helps in determining
     * the appropriate view and other operational contexts within the controller.
     */
    public $route;

    /**
     * @var string $view Specifies the name of the view file that should be rendered by the controller.
     * This property is usually determined based on the current action and can be adjusted
     * to render a different view if necessary.
     */
    public $view;

    /**
     * @var array $data An associative array that stores the data to be passed from the controller to the view.
     * This data is extracted into variables within the view, allowing dynamic content rendering.
     */
    public $data = [];

    /**
     * @var array $meta Contains meta information for the webpage, such as 'title', 'desc' (description),
     * and 'keywords'. These are important for SEO and are used to populate the meta tags in the view's HTML head section.
     */
    public $meta = ['title'=>'','desc'=>'', 'keywords'=>''];

    /**
     * @var string|null $layout Specifies the layout file to be used when rendering the view.
     * If null or not set, a default layout may be used. This allows for flexible page layouts across different parts of the application.
     */
    public $layout;


    /**
     * Constructs the controller based on the provided route information.
     *
     * Initializes the controller with route details, determining the appropriate view
     * to use based on the action specified in the route.
     *
     * @param array $route The route information, including the controller, action, and any prefixes.
     */
    public function __construct($route){

        $this->route = $route;
        $this->view = strtolower($route['action']);

    }

    /**
     * Renders the view associated with the controller's action.
     *
     * This method initializes a View object with the specified route, layout, view name, and meta information.
     * It then renders the view using the provided data, facilitating the display of dynamic content based on the action
     * currently being processed. This approach allows for a clear separation of the controller logic from the view layer,
     * ensuring that the controller focuses on handling the request and business logic, while the view is solely responsible
     * for presenting the response to the user.
     *
     * @throws \Exception If there is an issue rendering the view.
     */
    public function getView(){

        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);

        $viewObject->render($this->data);

    }

    /**
     * Sets the data to be passed to the view.
     *
     * This method is used to pass data from the controller to the view. The data is compacted into an array
     * in the derived controllers and then set to this controller's data property. The View::render method will
     * later extract these data into variables, making them accessible within the view file. This mechanism
     * facilitates the transfer of data from the controller to the view, enabling dynamic content rendering
     * based on the data provided by the controller.
     *
     * @param array $data An associative array of data to be passed to the view.
     */
    public function set($data) {
        $this->data = $data;
    }

    /**
     * Sets the meta information for the view.
     *
     * This method is utilized to define meta information such as the title, description, and keywords
     * of the webpage. These meta details are crucial for SEO and provide context about the content
     * of the page to search engines and social media platforms. The meta information is stored in
     * the controller's meta property and can be accessed within the view to populate the corresponding
     * meta tags in the HTML head section.
     *
     * @param string $title The title of the webpage.
     * @param string $desc The description of the webpage content.
     * @param string $keywords Comma-separated keywords related to the webpage content.
     */
    public function setMeta($title = '', $desc = '', $keywords = ''){
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }

}