$modx->addPackage('mypackage','/full/path/to/core/components/mypackage/model/','mp_');
 
$my_items = $modx->getCollection('Items');
 
$output = '';
 
if ($my_items) {
    foreach ($my_items as $item) {
        $output .= $item->get('itemname') . '<br/>';
    }
}
else {
    return 'No items found.';
}
 
return $output;