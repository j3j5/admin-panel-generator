<?php

use VivifyIdeas\AdminPanelGenerator\Providers\AdminPanelGeneratorProvider;

function packageConfig($config)
{
    return config(AdminPanelGeneratorProvider::PACKAGE_NAME_CONFIG . '.' . $config);
}

function packageView($name, $data = array())
{
    return view(AdminPanelGeneratorProvider::PACKAGE_NAME . '::' . $name, $data);
}

function packageTranslation($key)
{
	return trans(AdminPanelGeneratorProvider::PACKAGE_NAME . '::' . $key);
}
