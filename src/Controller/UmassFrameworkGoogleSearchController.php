<?php

declare(strict_types=1);

namespace Drupal\umass_framework_google_search\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

// NOTE: Need to unpack logic of this ENV
// use WebEco\Env;
// Env::getSite()->getSiteName()
/**
 * Delivers the Google Search results page.
 */

class UmassFrameworkGoogleSearchController extends ControllerBase
{
    /**
     * Page callback for addressing the route request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The request object.
     */
    public function page(Request $request)
    {
        $query = (string) Xss::filter($request->query->get('q'));
        return [
            '#type' => 'inline_template',
            '#template' => '{{ include(template) }}',
            '#context' => [
                'template' => '@umass_framework_google_search/umass-framework-google-search-results.html.twig',
                'site' => 'engineering',
                'query' => $query,
            ],
        ];
    }
    /**
     * Route title callback.
     *
     * @return string
     *   The page title.
     */
    public function title(Request $request) {
        $query = Xss::filter($request->query->get('q'));
        if (empty($query)) {
            return $this->t('Search');
        }
        return $this->t('Search results for "@query"', ['@query' => $query]);
    }
}