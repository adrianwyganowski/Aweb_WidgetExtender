<?php

namespace Aweb\WidgetExtender\Model\Config;

use Magento\Framework\Config\ConverterInterface;

class Converter implements ConverterInterface
{
    public function convert($source)
    {
        $widgets = $source->getElementsByTagName('widget');

        if (!$widgets->length) {
            return $source;
        }
        $widgetCollection = [];

        foreach ($widgets as $widgetIndex => $widget) {
            foreach ($widget->childNodes as $widgetInfo) {
                if ($widgetInfo->nodeName === "#text") {
                    continue;
                }
                if ($widgetInfo->nodeName === 'templates_list') {
                    $widgetCollection[$widgetIndex]['templates'] = $this->extractTemplates($widgetInfo);
                } else {
                    $widgetCollection[$widgetIndex][$widgetInfo->nodeName] = $widgetInfo->nodeValue;
                }
            }
        }

        return ['widgets' => $widgetCollection];
    }

    private function extractTemplates($templatesNode)
    {
        $templates = [];
        $templateIndex = 0;
        foreach ($templatesNode->childNodes as $template) {
            if ($template->nodeName === "#text") {
                continue;
            }
            foreach ($template->childNodes as $templateInfo) {
                if ($templateInfo->nodeName === "#text") {
                    continue;
                }
                $templates[$templateIndex][$templateInfo->nodeName] = $templateInfo->nodeValue;
            }
            $templateIndex++;
        }
        return $templates;
    }
}
