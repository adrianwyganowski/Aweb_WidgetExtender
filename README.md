# Widget template extender

This module allows you to extend existing widgets with new custom templates.

## Preparation

1. Instal module
2. Add widget_template_extender.xml to app/etc
3. Add your templates to XML file like so:

```xml
<?xml version="1.0" ?>
<config
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:noNamespaceSchemaLocation="widget_template_extender.xsd"
>
    <widget_list>
        <widget>
            <widget_class>Magento\Catalog\Block\Product\Widget\Link</widget_class> <!-- Widget which you want to extend -->
            <templates_list>
                <template>
                    <new_template_label>First template</new_template_label> <!-- Label which will be displayed in the admin -->
                    <new_template_path>Aweb_WidgetExtender::first.phtml</new_template_path> <!-- Path to the template -->
                </template>
                <template>
                    <new_template_label>Second template</new_template_label>
                    <new_template_path>Aweb_WidgetExtender::second.phtml</new_template_path>
                </template>
            </templates_list>
        </widget>
        <widget>
            <widget_class>Magento\Catalog\Block\Product\Widget\Pager</widget_class>
            <templates_list>
                <template>
                    <new_template_label>Third template</new_template_label>
                    <new_template_path>Aweb_WidgetExtender::third.phtml</new_template_path>
                </template>
            </templates_list>
        </widget>
    </widget_list>
</config>
```
4. Place you templates in the Aweb_WidgetExtender/templates like so:

```
Aweb_WidgetExtender/templates/first.phtml
Aweb_WidgetExtender/templates/second.phtml
...
```

5. bin/magento setup:upgrade
