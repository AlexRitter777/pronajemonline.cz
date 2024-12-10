<?php

namespace pronajem\libs;

use DI\Attribute\Inject;
use pronajem\App;
use URLify;

/**
 * Class Slugger
 * Generates unique slugs for database records.
 */
class Slugger
{

    /**
     * Pagination parameters injected via constructor..
     *
     * @var PaginationSetParams
     */
    private PaginationSetParams $pagination;


    public function __construct(PaginationSetParams $pagination){
        $this->pagination = $pagination;
    }

    /**
     * Generates a unique slug for a given title in a specified table.
     *
     * @param string $title The title to generate the slug from.
     * @param string $table The table to check for slug uniqueness.
     * @return string A unique slug.
     */
    public function createSlug(string $title, string $table) : string {

        // Get DI Container instance
        $container = App::$app->getProperty('container');

        // Generate base slug using URLify
        $slug = URLify::slug($title);

        // Create a model object for the specified table
        $modelObject = $container->make($table, [
            'pagination' => $this->pagination
        ]);

        // Ensure slug uniqueness by incrementing if necessary
        while ($modelObject->getOneRecordBySlug($slug)) {
            $slug = $this->incrementSlugIndex($slug);
        }

        return $slug;
                
    }

    /**
     * Increments the numeric index at the end of the slug or appends "-1" if not present.
     *
     * @param string $slug The slug to increment.
     * @return string The incremented slug.
     */
    private static function incrementSlugIndex(string $slug): string
    {
        // Check for a numeric index at the end of the slug
        if (preg_match('/-(\d+)$/', $slug, $matches)) {
            // Increment the number and replace the suffix
            $index = (int)$matches[1] + 1;
            return preg_replace('/-\d+$/', '-' . $index, $slug);
        }

        // If no numeric suffix, append "-1"
        return $slug . '-1';
    }


}