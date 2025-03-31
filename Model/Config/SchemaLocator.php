<?php

namespace Aweb\WidgetExtender\Model\Config;

use Magento\Framework\Config\SchemaLocatorInterface;
use Magento\Framework\Module\Dir;
use Magento\Framework\Module\Dir\Reader;


class SchemaLocator implements SchemaLocatorInterface
{
    const CONFIG_FILE_SCHEMA = 'widget_template_extender.xsd';
    protected $schema = null;
    protected $perFileSchema = null;


    public function __construct(Reader $moduleReader)
    {
        $configDir = $moduleReader->getModuleDir(Dir::MODULE_ETC_DIR, 'Aweb_WidgetExtender');
        $this->schema = $configDir . DIRECTORY_SEPARATOR . self::CONFIG_FILE_SCHEMA;
        $this->perFileSchema = $configDir . DIRECTORY_SEPARATOR . self::CONFIG_FILE_SCHEMA;
    }

    public function getSchema()
    {
        return $this->schema;
    }


    public function getPerFileSchema()
    {
        return $this->perFileSchema;
    }
}