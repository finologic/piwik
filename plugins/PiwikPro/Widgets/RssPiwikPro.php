<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\PiwikPro\Widgets;

use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Widget\WidgetConfig;
use Piwik\Plugins\ExampleRssWidget\RssRenderer;

class RssPiwikPro extends \Piwik\Widget\Widget
{
    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('About Piwik');
        $config->setName('PiwikPro_WidgetBlogTitle');
        $config->setIsEnabled(StaticContainer::get('Piwik\PiwikPro\Advertising')->arePiwikProAdsEnabled());
    }

    public function render()
    {
        try {
            $rss = new RssRenderer('https://piwik.pro/feed/');
            $rss->showDescription(true);

            return $rss->get();

        } catch (\Exception $e) {

            return $this->error($e);
        }
    }

    /**
     * @param \Exception $e
     * @return string
     */
    private function error($e)
    {
        return '<div class="pk-emptyDataTable">'
             . Piwik::translate('General_ErrorRequest', array('', ''))
             . ' - ' . $e->getMessage() . '</div>';
    }
}