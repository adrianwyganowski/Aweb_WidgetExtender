<?php

namespace Aweb\WidgetExtender\Plugin\Model\Instance;

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

    public function afterGetWidgetConfigAsArray(Widget $subject, DataObject $result)
    {
        $parameters = $result['parameters'];
        $templates = [];

        $templates = isset($parameters['template']) ? $parameters['template']->getValues() : null;

        if ($templates == null) {
            return $result;
        }

        $instanceType = $subject->getInstanceType();

        $widgetList = $this->widgetList->get('widgets');

        if ($widgetList == null) {
            return $subject;
        }

        foreach ($widgetList as $widget) {
            if ($widget['widget_class'] == $instanceType) {
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

        $parameters['template']['values'] = $templates;
        $result['parameters'] = $parameters;

        return $result;
    }
}
