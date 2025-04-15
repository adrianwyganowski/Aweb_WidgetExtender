<?php

namespace Aweb\WidgetExtender\Plugin\Model\Instance;

use Magento\Widget\Model\Widget\Instance as Widget;
use Aweb\WidgetExtender\Model\Config\Data as WidgetExtenderConfig;
use Aweb\WidgetExtender\Helper\DefaultTemplate as DefaultTemplateHelper;

class AddTemplatesPlugin
{
    private WidgetExtenderConfig $widgetList;
    private DefaultTemplateHelper $defaultTemplateHelper;

    public function __construct(
        WidgetExtenderConfig $widgetList,
        DefaultTemplateHelper $defaultTemplateHelper
    )
    {
        $this->widgetList = $widgetList;
        $this->defaultTemplateHelper = $defaultTemplateHelper;
    }

    public function afterGetWidgetConfigAsArray(Widget $subject, array $result)
    {
        $parameters = $result['parameters'];
        $templates = [];

        $templates = isset($parameters['template']) ? $parameters['template']['values'] : [];

        $instanceType = $subject->getInstanceType();

        $widgetList = $this->widgetList->get('widgets');

        if ($widgetList == null) {
            return $result;
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

        if ($templates == []) {
            return $result;
        }

        if (!isset($parameters['template'])) {
            $parameters['template'] = $this->defaultTemplateHelper->defaultTemplate();

            array_push(
                $templates,
                [
                    'value' => '',
                    'label' => 'Default Template'
                ]
            );
        }

        $parameters['template']['values'] = $templates;
        $result['parameters'] = $parameters;

        return $result;
    }
}
