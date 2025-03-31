<?php

namespace Aweb\WidgetExtender\Model\Config;

use Magento\Framework\Config\ConverterInterface;

class Converter implements ConverterInterface
{
    public function convert($source)
    {
        $widgets = $source->getElementsByTagName('widget');

        if (!$widgets->length) {
            $source;
        }

        $widgetInfoArray = [];
        $iterator = 0;
        foreach ($widgets as $widget) {
            foreach ($widget->childNodes as $widgetInfo) {
                if ($widgetInfo->nodeName == 'templates_list') {
                    $j = 0;
                    foreach ($widgetInfo->childNodes as $template) {
                        if ($template->nodeName != "#text") {
                            foreach ($template->childNodes as $templateInfo) {
                                if ($templateInfo->nodeName != "#text") {
                                    $widgetInfoArray[$iterator]['templates'][$j][$templateInfo->nodeName] = $templateInfo->nodeValue;
                                }
                            }
                            $j++;
                        }
                    }
                } else {
                    if ($widgetInfo->nodeName != "#text") {
                        $widgetInfoArray[$iterator][$widgetInfo->nodeName] = $widgetInfo->nodeValue;
                    }
                }
            }
            $iterator++;
        }

        return ['widgets' => $widgetInfoArray];
    }
}