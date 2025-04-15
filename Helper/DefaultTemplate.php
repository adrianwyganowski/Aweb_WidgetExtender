<?php

namespace Aweb\WidgetExtender\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\DataObject;


class DefaultTemplate extends AbstractHelper
{
    public function defaultTemplate()
    {
        $defaultTemplate = new DataObject();
        $defaultTemplate->setData('type', 'select');
        $defaultTemplate->setData('label', 'Template');
        $defaultTemplate->setData('key', 'template');
        $defaultTemplate->setData('sortOrder', 1000);
        $defaultTemplate->setData('visible', "1");
        $defaultTemplate->setData('required', "0");
        $defaultTemplate->setData('value', '');

        return $defaultTemplate;
}
}
