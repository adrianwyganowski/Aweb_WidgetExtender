<?php
declare(strict_types=1);

namespace Aweb\WidgetExtender\Plugin\Model;

use Magento\Framework\DataObject;
use Magento\Widget\Model\Widget;
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

    public function afterGetConfigAsObject(Widget $subject, DataObject $result)
    {
        $parameters = $result->getParameters();
        $templates = isset($parameters['template']) ? $parameters['template']->getValues() : [];
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

        $parameters['template']->setData('values', $templates);
        $result->setData('parameters', $parameters);

        return $result;
    }
}
