<?php
function elements_modplugin_5($scriptProperties= array()) {
global $modx;
if (is_array($scriptProperties)) {
extract($scriptProperties, EXTR_SKIP);
}
/**
 * Frontpage Editor plugin
 *
 * @author    S. Hamblett <steve.hamblett@linux.com>
 * @copyright 2010 S. Hamblett
 * @license   GPLv3 http://www.gnu.org/licenses/gpl.html
 */

/* Don't process anything if we have no logged in web user */
$modx->getVersionData();
if (version_compare($modx->version['full_version'], '2.1.0-rc1', '<=')) {

    if ( !$_SESSION['webValidated'] == 1 ) return;

} else {

    $authenticated = $modx->user->isAuthenticated($modx->context->get('key'));
    if ( $authenticated != 1 ) return;
}

/* Create a Frontpage class */
$corePath = $modx->getOption('frontpage.core_path',null,$modx->getOption('core_path').'components/frontpage/');
include_once $corePath . "model/frontpage/frontpage.class.php";
$fp = new Frontpage($modx);
$fp->initialize($scriptProperties);

/* Run FP in front-end */
$output = $fp->run();

return $output;
}
