<?php

namespace Aweb\WidgetExtender\Plugin\Model;

use Magento\Framework\DataObject;
use Magento\Widget\Model\Widget;
use Aweb\WidgetExtender\Model\Config\Data as WidgetExtenderConfig;

class AddTemplatesPlugin
{
    private WidgetExtenderConfig $widgetList;

    public function __construct(
        WidgetExtenderConfig $widgetList,
    )
    {
        $this->widgetList = $widgetList;
    }

    public function afterGetConfigAsObject(Widget $subject, DataObject $result)
    {
        $parameters = $result->getParameters();
        $templates = isset($parameters['template']) ? $parameters['template']->getValues() : null;

        if ($templates == null) {
            return $result;
        }

        $widgetList = $this->widgetList->get('widgets');

        if ($widgetList == null) {
            return $result;
        }

        foreach ($widgetList as $widget) {
            if ($widget['widget_class'] == $result->getType()) {
                foreach ($widget['templates'] as $template) {
                    array_push(
                        $templates,
                        [
                            'value' => $template['new_template_path'],
                            'label' => $template['new_template_label']
                        ]
                    );
                }
            }
        }

        $parameters['template']->setData('values', $templates);
        $result->setData('parameters', $parameters);

        return $result;
    }
}