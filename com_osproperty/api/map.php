<?php

define('_JEXEC', 1);
define('JPATH_BASE', dirname(__DIR__,3)); // Replace __DIR__ with the path to your component's directory.
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

$db = JFactory::getDBO();

if(isset($_GET['coordinates'])){
    $coordinates = $db->setQuery("
    Select #__osrs_properties.id, pro_small_desc as short_desc, pro_name as name,#__osrs_categories.id as category_id,pro_alias as link,price as mprice,pro_small_desc as short_desc, #__osrs_types.type_name as category, #__osrs_types.id as type, lat_add + 0 as lat, long_add + 0 as lng, #__osrs_cities.city as city_name, #__osrs_cities.id as city_code from #__osrs_properties
    JOIN #__osrs_types ON #__osrs_properties.pro_type = #__osrs_types.id
    JOIN #__osrs_property_categories ON #__osrs_properties.id =#__osrs_property_categories.pid
    JOIN #__osrs_categories ON #__osrs_categories.id = #__osrs_property_categories.category_id
    JOIN #__osrs_cities ON #__osrs_cities.id = #__osrs_properties.city
    WHERE #__osrs_properties.access = 1")->loadObjectList();
    echo json_encode($coordinates);
}

// $app = JFactory::getApplication('site');




?>