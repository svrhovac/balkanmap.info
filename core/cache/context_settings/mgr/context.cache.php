<?php  return array (
  'config' => 
  array (
    'allow_tags_in_post' => '1',
    'modRequest.class' => 'modManagerRequest',
  ),
  'resourceMap' => 
  array (
  ),
  'aliasMap' => 
  array (
  ),
  'webLinkMap' => 
  array (
  ),
  'eventMap' => 
  array (
    'OnChunkFormPrerender' => 
    array (
      4 => '4',
    ),
    'OnDocFormPrerender' => 
    array (
      6 => '6',
    ),
    'OnDocPublished' => 
    array (
      9 => '9',
      2 => '2',
    ),
    'OnDocUnPublished' => 
    array (
      2 => '2',
    ),
    'OnEmptyTrash' => 
    array (
      7 => '7',
    ),
    'OnFileEditFormPrerender' => 
    array (
      4 => '4',
    ),
    'OnManagerPageBeforeRender' => 
    array (
      6 => '6',
    ),
    'OnManagerPageInit' => 
    array (
      2 => '2',
    ),
    'OnPageNotFound' => 
    array (
      1 => '1',
      2 => '2',
    ),
    'OnPluginFormPrerender' => 
    array (
      4 => '4',
    ),
    'OnRichTextEditorRegister' => 
    array (
      4 => '4',
    ),
    'OnSiteRefresh' => 
    array (
      8 => '8',
    ),
    'OnSnipFormPrerender' => 
    array (
      4 => '4',
    ),
    'OnTempFormPrerender' => 
    array (
      4 => '4',
    ),
    'OnTVInputPropertiesList' => 
    array (
      6 => '6',
    ),
    'OnTVInputRenderList' => 
    array (
      6 => '6',
    ),
    'OnTVOutputRenderList' => 
    array (
      6 => '6',
    ),
    'OnTVOutputRenderPropertiesList' => 
    array (
      6 => '6',
    ),
    'OnWebPagePrerender' => 
    array (
      5 => '5',
      3 => '3',
    ),
  ),
  'pluginCache' => 
  array (
    1 => 
    array (
      'id' => '1',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'ArchivistFurl',
      'description' => 'Handles FURLs for Archivist.',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '/**
 * Archivist
 *
 * Copyright 2010-2011 by Shaun McCormick <shaun@modx.com>
 *
 * This file is part of Archivist, a simple archive navigation system for MODx
 * Revolution.
 *
 * Archivist is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Archivist is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Archivist; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package archivist
 */
/**
 * @var modX $modx
 * @package archivist
 */
if ($modx->event->name != \'OnPageNotFound\') return;

$archiveIds = $modx->getOption(\'archivist.archive_ids\',null,\'\');
if (empty($archiveIds)) return;
$archiveIds = explode(\',\',$archiveIds);

/* handle redirects */
$search = $_SERVER[\'REQUEST_URI\'];
$base_url = $modx->getOption(\'base_url\');
if ($base_url != \'/\') {
    $search = str_replace($base_url,\'\',$search);
}
$search = trim($search, \'/\');

/* get resource to redirect to */
$resourceId = false;
$prefix = \'arc_\';
foreach ($archiveIds as $archive) {
    $archive = explode(\':\',$archive);
    $archiveId = $archive[0];
    $alias = array_search($archiveId,$modx->aliasMap);
    if ($alias && strpos($search,$alias) !== false) {
        $search = str_replace($alias,\'\',$search);
        $resourceId = $archiveId;
        if (isset($archive[1])) $prefix = $archive[1];
    }
}
if (!$resourceId) return;

/* figure out archiving */
$params = explode(\'/\', $search);
if (count($params) < 1) return;

/* tag handling! */
if ($params[0] == \'tags\') {
    $_GET[\'tag\'] = $params[1];
} else if ($params[0] == \'user\' || $params[0] == \'author\') {
    $_GET[$prefix.\'author\'] = $params[1];
} else {
    /* set Archivist parameters for date-based archives */
    $_GET[$prefix.\'year\'] = $params[0];
    if (isset($params[1])) $_GET[$prefix.\'month\'] = $params[1];
    if (isset($params[2])) $_GET[$prefix.\'day\'] = $params[2];
}

/* forward */
$modx->sendForward($resourceId);
return;',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    2 => 
    array (
      'id' => '2',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'ArticlesPlugin',
      'description' => 'Handles FURLs for Articles.',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '/**
 * Articles
 *
 * Copyright 2011-12 by Shaun McCormick <shaun+articles@modx.com>
 *
 * Articles is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Articles is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Articles; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package articles
 */
/**
 * @var modX $modx
 * @var array $scriptProperties
 */
switch ($modx->event->name) {
    case \'OnManagerPageInit\':
        $cssFile = $modx->getOption(\'articles.assets_url\',null,$modx->getOption(\'assets_url\').\'components/articles/\').\'css/mgr.css\';
        $modx->regClientCSS($cssFile);
        break;
    case \'OnPageNotFound\':
        $corePath = $modx->getOption(\'articles.core_path\',null,$modx->getOption(\'core_path\').\'components/articles/\');
        require_once $corePath.\'model/articles/articlesrouter.class.php\';
        $router = new ArticlesRouter($modx);
        $router->route();
        return;
    case \'OnDocPublished\':
        /** @var Article $resource */
        $resource =& $scriptProperties[\'resource\'];
        if ($resource instanceof Article) {
            $resource->setArchiveUri();
            $resource->save();
            $modx->cacheManager->refresh(array(
                \'db\' => array(),
                \'auto_publish\' => array(\'contexts\' => array($resource->get(\'context_key\'))),
                \'context_settings\' => array(\'contexts\' => array($resource->get(\'context_key\'))),
                \'resource\' => array(\'contexts\' => array($resource->get(\'context_key\'))),
            ));
            $resource->notifyUpdateServices();
            $resource->sendNotifications();
        }
        break;
    case \'OnDocUnPublished\':
        $resource =& $scriptProperties[\'resource\'];
        break;

}
return;',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    3 => 
    array (
      'id' => '3',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'AutoFixImageSize',
      'description' => 'Fixes img elements with wrong width/height attributes. Uses phpThumbOf for generating correctly sized physical image files.',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '/**
 * @name AutoFixImageSize
 * @version 1.0.1 pl
 * @author Gerrit van Aaken <gerrit@praegnanz.de> April 2011 – January 2012
 *
 * @license GPLv2
 *
 * Fixes img elements with wrong width/height attributes. 
 * Uses phpThumbOf for generating correctly sized physical image files.
 *
 * Must be executed at "OnWebPagePrerender"
 */

// get parsed document as string
$str = $modx->resource->_output;

// get configuration from global object
$config = $modx->getConfig();

// find all img elements with a src attribute
preg_match_all(\'|\\<img.*?src=[",\\\'](.*?)[",\\\'].*?[^>]+\\>|i\', $str, $filenames);

// loop through all found img elements
foreach($filenames[1] as $i => $filename) {

  $img_old = $filenames[0][$i];
  $allowcaching = false; // pessimistic

  // is file already cached?
  if (strpos($filename,"?") == false || strpos($filename,"/phpthumb") == false) {

    // check if external caching is allowed
    if (substr($filename,0,7) == "http://" || substr($filename,0,8) == "https://") {
      $pre = "";
      if ($config[\'phpthumb_nohotlink_enabled\']) {
        foreach (explode(",", $config[\'phpthumb_nohotlink_valid_domains\']) as $alldomain) {
          if ( strpos(strtolower($filename), strtolower(trim($alldomain))) != false) {
            $allowcaching = true;
          }
        } 
      } else {
        $allowcaching = true;
      }
    } else {
      $pre = $config[\'base_path\'];
      $allowcaching = true;
    }
  }
  
  // do we have physical access to the file?

$mypath = $pre.str_replace(\'%20\', \' \', $filename);
  if ($allowcaching && $dimensions = getimagesize($mypath, $info)) {

    // find width and height attribut and save value
    preg_match_all(\'|width=[",\\\']([0-9]+?)[",\\\']|i\', $filenames[0][$i], $widths);
    if (isset($widths[1][0])) {
      $width = $widths[1][0];
    } else {
      $width = false;
    }
    preg_match_all(\'|height=[",\\\']([0-9]+?)[",\\\']|i\', $filenames[0][$i], $heights);
    if (isset($heights[1][0])) {
      $height = $heights[1][0];
    } else {
      $height = false;
    }

    // if resizing needed...
    if (($width && $width != $dimensions[0]) || ($height && $height != $dimensions[1])) {

      // prepare resizing metadata
      $filetype = strtolower(substr($filename, strrpos($filename,".")+1));
      $image = array();
      $image[\'input\'] = $filename;
      $image[\'options\'] = "f=".$filetype."&h=".$height."&w=".$width."&iar=1"; 

      // perform physical resizing and caching via phpthumbof
      $cacheurl = $modx->runSnippet(\'phpthumbof\',$image);

      // set freshly cached image file location into old src attribute
      $img_new = str_replace($filename, $cacheurl, $img_old);  

      // replace old image element with new one on whole page content
      $str = str_replace($img_old, $img_new, $str);  
    }
  }
}

// exchange the output string with the replaced one
$modx->resource->_output = $str;',
      'locked' => '0',
      'properties' => 'a:0:{}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'assets/dev/autofiximagesize.php',
    ),
    4 => 
    array (
      'id' => '4',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'CodeMirror',
      'description' => 'CodeMirror 2.0.0-pl plugin for MODx Revolution',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '/**
 * @package codemirror
 */
if ($modx->event->name == \'OnRichTextEditorRegister\') {
    $modx->event->output(\'CodeMirror\');
    return;
}
if ($modx->getOption(\'which_element_editor\',null,\'CodeMirror\') != \'CodeMirror\') return;
if (!$modx->getOption(\'use_editor\',null,true)) return;
if (!$modx->getOption(\'codemirror.enable\',null,true)) return;

$codeMirror = $modx->getService(\'codemirror\',\'CodeMirror\',$modx->getOption(\'codemirror.core_path\',null,$modx->getOption(\'core_path\').\'components/codemirror/\').\'model/codemirror/\');
if (!($codeMirror instanceof CodeMirror)) return \'\';


$options = array(
    \'modx_path\' => $codeMirror->config[\'assetsUrl\'],
    \'electricChars\' => (boolean)$modx->getOption(\'electricChars\',$scriptProperties,true),
    \'enterMode\' => $modx->getOption(\'tabMode\',$scriptProperties,\'indent\'),
    \'firstLineNumber\' => (int)$modx->getOption(\'firstLineNumber\',$scriptProperties,1),
    \'highlightLine\' => (boolean)$modx->getOption(\'highlightLine\',$scriptProperties,true),
    \'indentUnit\' => (int)$modx->getOption(\'indentUnit\',$scriptProperties,$modx->getOption(\'indent_unit\',$scriptProperties,2)),
    \'indentWithTabs\' => (boolean)$modx->getOption(\'indentWithTabs\',$scriptProperties,true),
    \'lineNumbers\' => (boolean)$modx->getOption(\'lineNumbers\',$scriptProperties,$modx->getOption(\'line_numbers\',$scriptProperties,true)),
    \'matchBrackets\' => (boolean)$modx->getOption(\'matchBrackets\',$scriptProperties,true),
    \'showSearchForm\' => (boolean)$modx->getOption(\'showSearchForm\',$scriptProperties,true),
    \'tabMode\' => $modx->getOption(\'tabMode\',$scriptProperties,$modx->getOption(\'tab_mode\',$scriptProperties,\'classic\')),
    \'undoDepth\' => $modx->getOption(\'undoDepth\',$scriptProperties,40),
);

$load = false;
switch ($modx->event->name) {
    case \'OnSnipFormPrerender\':
        $options[\'modx_loader\'] = \'onSnippet\';
        $options[\'mode\'] = \'php\';
        $load = true;
        break;
    case \'OnTempFormPrerender\':
        $options[\'modx_loader\'] = \'onTemplate\';
        $options[\'mode\'] = \'htmlmixed\';
        $load = true;
        break;
    case \'OnChunkFormPrerender\':
        $options[\'modx_loader\'] = \'onChunk\';
        $options[\'mode\'] = \'htmlmixed\';
        $load = true;
        break;
    case \'OnPluginFormPrerender\':
        $options[\'modx_loader\'] = \'onPlugin\';
        $options[\'mode\'] = \'php\';
        $load = true;
        break;
    /* disabling TVs for now, since it causes problems with newlines
    case \'OnTVFormPrerender\':
        $options[\'modx_loader\'] = \'onTV\';
        $options[\'height\'] = \'250px\';
        $load = true;
        break;*/
    case \'OnFileEditFormPrerender\':
        $options[\'modx_loader\'] = \'onFile\';
        $options[\'mode\'] = \'php\';
        $load = true;
        break;
    /* debated whether or not to use */
    case \'OnRichTextEditorInit\':
        break;
    case \'OnRichTextBrowserInit\':
        break;
}

if ($load) {
    $options[\'searchTpl\'] = $codeMirror->getChunk(\'search\');

    $modx->regClientStartupHTMLBlock(\'<script type="text/javascript">MODx.codem = \'.$modx->toJSON($options).\';</script>\');
    $modx->regClientCSS($codeMirror->config[\'assetsUrl\'].\'css/codemirror-compressed.css\');
    $modx->regClientCSS($codeMirror->config[\'assetsUrl\'].\'css/cm.css\');
    $modx->regClientStartupScript($codeMirror->config[\'assetsUrl\'].\'js/codemirror-compressed.js\');
    $modx->regClientStartupScript($codeMirror->config[\'assetsUrl\'].\'js/cm.js\');
}

return;',
      'locked' => '0',
      'properties' => 'a:11:{s:10:"indentUnit";a:6:{s:4:"name";s:10:"indentUnit";s:4:"desc";s:23:"prop_cm.indentUnit_desc";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";i:2;s:7:"lexicon";s:21:"codemirror:properties";}s:14:"indentWithTabs";a:6:{s:4:"name";s:14:"indentWithTabs";s:4:"desc";s:27:"prop_cm.indentWithTabs_desc";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";s:21:"codemirror:properties";}s:7:"tabMode";a:6:{s:4:"name";s:7:"tabMode";s:4:"desc";s:20:"prop_cm.tabMode_desc";s:4:"type";s:4:"list";s:7:"options";a:4:{i:0;a:2:{s:4:"text";s:15:"prop_cm.classic";s:5:"value";s:7:"classic";}i:1;a:2:{s:4:"text";s:13:"prop_cm.shift";s:5:"value";s:5:"shift";}i:2;a:2:{s:4:"text";s:14:"prop_cm.indent";s:5:"value";s:6:"indent";}i:3;a:2:{s:4:"text";s:23:"prop_cm.browser_default";s:5:"value";s:7:"default";}}s:5:"value";s:7:"classic";s:7:"lexicon";s:21:"codemirror:properties";}s:9:"enterMode";a:6:{s:4:"name";s:9:"enterMode";s:4:"desc";s:22:"prop_cm.enterMode_desc";s:4:"type";s:4:"list";s:7:"options";a:3:{i:0;a:2:{s:4:"text";s:14:"prop_cm.indent";s:5:"value";s:6:"indent";}i:1;a:2:{s:4:"text";s:12:"prop_cm.keep";s:5:"value";s:4:"keep";}i:2;a:2:{s:4:"text";s:12:"prop_cm.flat";s:5:"value";s:4:"flat";}}s:5:"value";s:6:"indent";s:7:"lexicon";s:21:"codemirror:properties";}s:13:"electricChars";a:6:{s:4:"name";s:13:"electricChars";s:4:"desc";s:26:"prop_cm.electricChars_desc";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";s:21:"codemirror:properties";}s:11:"lineNumbers";a:6:{s:4:"name";s:11:"lineNumbers";s:4:"desc";s:24:"prop_cm.lineNumbers_desc";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";s:21:"codemirror:properties";}s:15:"firstLineNumber";a:6:{s:4:"name";s:15:"firstLineNumber";s:4:"desc";s:28:"prop_cm.firstLineNumber_desc";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";i:1;s:7:"lexicon";s:21:"codemirror:properties";}s:13:"highlightLine";a:6:{s:4:"name";s:13:"highlightLine";s:4:"desc";s:26:"prop_cm.highlightLine_desc";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";s:21:"codemirror:properties";}s:13:"matchBrackets";a:6:{s:4:"name";s:13:"matchBrackets";s:4:"desc";s:26:"prop_cm.matchBrackets_desc";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";s:21:"codemirror:properties";}s:14:"showSearchForm";a:6:{s:4:"name";s:14:"showSearchForm";s:4:"desc";s:27:"prop_cm.showSearchForm_desc";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";s:21:"codemirror:properties";}s:9:"undoDepth";a:6:{s:4:"name";s:9:"undoDepth";s:4:"desc";s:22:"prop_cm.undoDepth_desc";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";i:40;s:7:"lexicon";s:21:"codemirror:properties";}}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    5 => 
    array (
      'id' => '5',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'Frontpage',
      'description' => 'Frontpage editor',
      'editor_type' => '0',
      'category' => '9',
      'cache_type' => '0',
      'plugincode' => '/**
 * Frontpage Editor plugin
 *
 * @author    S. Hamblett <steve.hamblett@linux.com>
 * @copyright 2010 S. Hamblett
 * @license   GPLv3 http://www.gnu.org/licenses/gpl.html
 */

/* Don\'t process anything if we have no logged in web user */
$modx->getVersionData();
if (version_compare($modx->version[\'full_version\'], \'2.1.0-rc1\', \'<=\')) {

    if ( !$_SESSION[\'webValidated\'] == 1 ) return;

} else {

    $authenticated = $modx->user->isAuthenticated($modx->context->get(\'key\'));
    if ( $authenticated != 1 ) return;
}

/* Create a Frontpage class */
$corePath = $modx->getOption(\'frontpage.core_path\',null,$modx->getOption(\'core_path\').\'components/frontpage/\');
include_once $corePath . "model/frontpage/frontpage.class.php";
$fp = new Frontpage($modx);
$fp->initialize($scriptProperties);

/* Run FP in front-end */
$output = $fp->run();

return $output;',
      'locked' => '0',
      'properties' => 'a:12:{s:10:"loadJQuery";a:6:{s:4:"name";s:10:"loadJQuery";s:4:"desc";s:89:"Load jQuery from this package, set to false if you already have jQuery in your front end.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:0;s:7:"lexicon";N;}s:16:"jQueryNoConflict";a:6:{s:4:"name";s:16:"jQueryNoConflict";s:4:"desc";s:31:"Set jQuery to no conflict mode.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:0;s:7:"lexicon";N;}s:10:"showCreate";a:6:{s:4:"name";s:10:"showCreate";s:4:"desc";s:22:"Show the create button";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:8:"showEdit";a:6:{s:4:"name";s:8:"showEdit";s:4:"desc";s:20:"Show the edit button";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:15:"autohideToolbar";a:6:{s:4:"name";s:15:"autohideToolbar";s:4:"desc";s:21:"Autohide the toolbar.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:16:"performRoleCheck";a:6:{s:4:"name";s:16:"performRoleCheck";s:4:"desc";s:38:"Check roles for access to the toolbar.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:0;s:7:"lexicon";N;}s:19:"contentManagerRoles";a:6:{s:4:"name";s:19:"contentManagerRoles";s:4:"desc";s:66:"Roles allowed access to the toolbar(Super User always has access).";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:0:"";s:7:"lexicon";N;}s:8:"boxWidth";a:6:{s:4:"name";s:8:"boxWidth";s:4:"desc";s:15:"Colorbox width.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:3:"90%";s:7:"lexicon";N;}s:9:"boxHeight";a:6:{s:4:"name";s:9:"boxHeight";s:4:"desc";s:16:"Colorbox height.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:3:"90%";s:7:"lexicon";N;}s:10:"jQueryPath";a:6:{s:4:"name";s:10:"jQueryPath";s:4:"desc";s:28:"URL path to a jQuery script.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:64:"https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js";s:7:"lexicon";N;}s:10:"editMethod";a:6:{s:4:"name";s:10:"editMethod";s:4:"desc";s:28:"Frontpage edit/create method";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:7:"classic";s:7:"lexicon";N;}s:11:"activeAloha";a:6:{s:4:"name";s:11:"activeAloha";s:4:"desc";s:28:"Uas Aloha on marked up pages";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";s:5:"false";s:7:"lexicon";N;}}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    6 => 
    array (
      'id' => '6',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'GalleryCustomTV',
      'description' => '',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '/**
 * Handles plugin events for Gallery\'s Custom TV
 * 
 * @package gallery
 */
$corePath = $modx->getOption(\'gallery.core_path\',null,$modx->getOption(\'core_path\').\'components/gallery/\');
switch ($modx->event->name) {
    case \'OnTVInputRenderList\':
        $modx->event->output($corePath.\'elements/tv/input/\');
        break;
    case \'OnTVOutputRenderList\':
        $modx->event->output($corePath.\'elements/tv/output/\');
        break;
    case \'OnTVInputPropertiesList\':
        $modx->event->output($corePath.\'elements/tv/inputoptions/\');
        break;
    case \'OnTVOutputRenderPropertiesList\':
        $modx->event->output($corePath.\'elements/tv/properties/\');
        break;
    case \'OnManagerPageBeforeRender\':
        $gallery = $modx->getService(\'gallery\',\'Gallery\',$modx->getOption(\'gallery.core_path\',null,$modx->getOption(\'core_path\').\'components/gallery/\').\'model/gallery/\',$scriptProperties);
        if (!($gallery instanceof Gallery)) return \'\';

        $snippetIds = \'\';
        $gallerySnippet = $modx->getObject(\'modSnippet\',array(\'name\' => \'Gallery\'));
        if ($gallerySnippet) {
            $snippetIds .= \'GAL.snippetGallery = "\'.$gallerySnippet->get(\'id\').\'";\'."\\n";
        }
        $galleryItemSnippet = $modx->getObject(\'modSnippet\',array(\'name\' => \'GalleryItem\'));
        if ($galleryItemSnippet) {
            $snippetIds .= \'GAL.snippetGalleryItem = "\'.$galleryItemSnippet->get(\'id\').\'";\'."\\n";
        }

        $jsDir = $modx->getOption(\'gallery.assets_url\',null,$modx->getOption(\'assets_url\').\'components/gallery/\').\'js/mgr/\';
        $modx->controller->addLexiconTopic(\'gallery:default\');
        $modx->controller->addJavascript($jsDir.\'gallery.js\');
        $modx->controller->addJavascript($jsDir.\'tree.js\');
        $modx->controller->addHtml(\'<script type="text/javascript">
        Ext.onReady(function() {
            GAL.config.connector_url = "\'.$gallery->config[\'connectorUrl\'].\'";
            \'.$snippetIds.\'
        });
        </script>\');
        break;
    case \'OnDocFormPrerender\':
        $gallery = $modx->getService(\'gallery\',\'Gallery\',$modx->getOption(\'gallery.core_path\',null,$modx->getOption(\'core_path\').\'components/gallery/\').\'model/gallery/\',$scriptProperties);
        if (!($gallery instanceof Gallery)) return \'\';

        /* assign gallery lang to JS */
        $modx->controller->addLexiconTopic(\'gallery:tv\');

        /* @var modAction $action */
        $action = $modx->getObject(\'modAction\',array(
            \'namespace\' => \'gallery\',
            \'controller\' => \'index\',
        ));
        $modx->controller->addHtml(\'<script type="text/javascript">
        Ext.onReady(function() {
            GAL.config = {};
            GAL.config.connector_url = "\'.$gallery->config[\'connectorUrl\'].\'";
            GAL.action = "\'.($action ? $action->get(\'id\') : 0).\'";
        });
        </script>\');
        $modx->controller->addJavascript($gallery->config[\'assetsUrl\'].\'js/mgr/tv/Spotlight.js\');
        $modx->controller->addJavascript($gallery->config[\'assetsUrl\'].\'js/mgr/gallery.js\');
        $modx->controller->addJavascript($gallery->config[\'assetsUrl\'].\'js/mgr/widgets/album/album.items.view.js\');
        $modx->controller->addJavascript($gallery->config[\'assetsUrl\'].\'js/mgr/widgets/album/album.tree.js\');
        $modx->controller->addJavascript($gallery->config[\'assetsUrl\'].\'js/mgr/tv/gal.browser.js\');
        $modx->controller->addJavascript($gallery->config[\'assetsUrl\'].\'js/mgr/tv/galtv.js\');
        $modx->controller->addCss($gallery->config[\'cssUrl\'].\'mgr.css\');
        break;
}
return;',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    7 => 
    array (
      'id' => '7',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'QuipResourceCleaner',
      'description' => 'Cleans up threads when a Resource is removed.',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '/**
 * Quip
 *
 * Copyright 2010-11 by Shaun McCormick <shaun@modx.com>
 *
 * This file is part of Quip, a simple commenting component for MODx Revolution.
 *
 * Quip is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Quip is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Quip; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package quip
 */
/**
 * Handles removal of threads if a Resource is deleted.
 * 
 * @package quip
 */
$quip = $modx->getService(\'quip\',\'Quip\',$modx->getOption(\'quip.core_path\',null,$modx->getOption(\'core_path\').\'components/quip/\').\'model/quip/\',$scriptProperties);
if (!($quip instanceof Quip)) return;

switch ($modx->event->name) {
    case \'OnEmptyTrash\':
        foreach ($scriptProperties[\'ids\'] as $id) {
            if (empty($id)) continue;

            $threads = $modx->getCollection(\'quipThread\',array(\'resource\' => $id));
            foreach ($threads as $thread) {
                $modx->log(modX::LOG_LEVEL_INFO,\'[Quip] Removing thread: \'.$thread->get(\'name\'));
                $thread->remove();
            }
        }
        break;
}
return;',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    8 => 
    array (
      'id' => '8',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'phpThumbOfCacheManager',
      'description' => 'Handles cache cleaning when clearing the Site Cache.',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '/**
 * Handles cache management for phpthumbof filter
 * 
 * @package phpthumbof
 */
if (empty($results)) $results = array();

switch ($modx->event->name) {
    case \'OnSiteRefresh\':
        if (!$modx->loadClass(\'modPhpThumb\',$modx->getOption(\'core_path\').\'model/phpthumb/\',true,true)) {
            $modx->log(modX::LOG_LEVEL_ERROR,\'[phpThumbOf] Could not load modPhpThumb class in plugin.\');
            return;
        }
        $assetsPath = $modx->getOption(\'phpthumbof.assets_path\',$scriptProperties,$modx->getOption(\'assets_path\').\'components/phpthumbof/\');
        $phpThumb = new modPhpThumb($modx);
        $cacheDir = $assetsPath.\'cache/\';

        /* clear local cache */
        if (!empty($cacheDir)) {
            foreach (new DirectoryIterator($cacheDir) as $file) {
                if (!$file->isFile()) continue;
                @unlink($file->getPathname());
            }
        }

        /* if using amazon s3, clear our cache there */
        $useS3 = $modx->getOption(\'phpthumbof.use_s3\',$scriptProperties,false);
        if ($useS3) {
            $modelPath = $modx->getOption(\'phpthumbof.core_path\',null,$modx->getOption(\'core_path\').\'components/phpthumbof/\').\'model/\';
            $modaws = $modx->getService(\'modaws\',\'modAws\',$modelPath.\'aws/\',$scriptProperties);
            $s3path = $modx->getOption(\'phpthumbof.s3_path\',null,\'phpthumbof/\');
            
            $list = $modaws->getObjectList($s3path);
            if (!empty($list) && is_array($list)) {
                foreach ($list as $obj) {
                    if (empty($obj->Key)) continue;

                    $results[] = $modaws->deleteObject($obj->Key);
                }
            }
        }

        break;
}
return;',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
    9 => 
    array (
      'id' => '9',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'MODxTweeter',
      'description' => '',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '$apiPath = MODX_ASSETS_PATH.\'components/modxtweeter/twitteroauth/\';
require_once $apiPath . \'twitteroauth.php\';
$tweet = $resource->getTVValue(\'tweet\');
$twitterStatus = $resource->getTVValue(\'twitterStatus\');

  
if($tweet=\'true\') {
  $CONSUMER_KEY = $modx->getOption(\'CONSUMER_KEY\', $scriptProperties, \'default\');
  $CONSUMER_SECRET = $modx->getOption(\'CONSUMER_SECRET\', $scriptProperties, \'default\');
  $OAUTH_TOKEN = $modx->getOption(\'OAUTH_TOKEN\', $scriptProperties, \'default\');
  $OAUTH_SECRET = $modx->getOption(\'OAUTH_SECRET\', $scriptProperties, \'default\');

$resourceTitle = $resource->get(\'longtitle\');
  if(!$resourceTitle) {
    $resourceTitle = $resource->get(\'pagetitle\');
  }
  
  
  $hashProp = $modx->getOption(\'HASH_TAGS\', $scriptProperties, \'tags\');
    if($resource->getTVValue($hashProp)) {
  $hashTagList = "#" . str_replace(" ", "", $resource->getTVValue($hashProp));
  $hashTagList = str_replace(",", " #", $hashTagList);
    }

$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $OAUTH_TOKEN, $OAUTH_SECRET);
$content = $connection->get(\'account/verify_credentials\');

$message = $twitterStatus . " " . $hashTagList;
$connection->post(\'statuses/update\', array(\'status\' => $message));
}',
      'locked' => '0',
      'properties' => 'a:5:{s:12:"CONSUMER_KEY";a:6:{s:4:"name";s:12:"CONSUMER_KEY";s:4:"desc";s:33:"CONSUMER_KEY from dev.twitter.com";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";N;}s:15:"CONSUMER_SECRET";a:6:{s:4:"name";s:15:"CONSUMER_SECRET";s:4:"desc";s:36:"CONSUMER_SECRET from dev.twitter.com";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";N;}s:11:"OAUTH_TOKEN";a:6:{s:4:"name";s:11:"OAUTH_TOKEN";s:4:"desc";s:32:"OAUTH_TOKEN from dev.twitter.com";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";N;}s:12:"OAUTH_SECRET";a:6:{s:4:"name";s:12:"OAUTH_SECRET";s:4:"desc";s:33:"OAUTH_SECRET from dev.twitter.com";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";N;}s:9:"HASH_TAGS";a:6:{s:4:"name";s:9:"HASH_TAGS";s:4:"desc";s:0:"";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:4:"tags";s:7:"lexicon";N;}}',
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => '',
    ),
  ),
  'policies' => 
  array (
    'modAccessContext' => 
    array (
      'mgr' => 
      array (
        0 => 
        array (
          'principal' => 1,
          'authority' => 0,
          'policy' => 
          array (
            'about' => true,
            'access_permissions' => true,
            'actions' => true,
            'change_password' => true,
            'change_profile' => true,
            'charsets' => true,
            'class_map' => true,
            'components' => true,
            'content_types' => true,
            'countries' => true,
            'create' => true,
            'credits' => true,
            'customize_forms' => true,
            'dashboards' => true,
            'database' => true,
            'database_truncate' => true,
            'delete_category' => true,
            'delete_chunk' => true,
            'delete_context' => true,
            'delete_document' => true,
            'delete_eventlog' => true,
            'delete_plugin' => true,
            'delete_propertyset' => true,
            'delete_role' => true,
            'delete_snippet' => true,
            'delete_template' => true,
            'delete_tv' => true,
            'delete_user' => true,
            'directory_chmod' => true,
            'directory_create' => true,
            'directory_list' => true,
            'directory_remove' => true,
            'directory_update' => true,
            'edit_category' => true,
            'edit_chunk' => true,
            'edit_context' => true,
            'edit_document' => true,
            'edit_locked' => true,
            'edit_plugin' => true,
            'edit_propertyset' => true,
            'edit_role' => true,
            'edit_snippet' => true,
            'edit_template' => true,
            'edit_tv' => true,
            'edit_user' => true,
            'element_tree' => true,
            'empty_cache' => true,
            'error_log_erase' => true,
            'error_log_view' => true,
            'export_static' => true,
            'file_create' => true,
            'file_list' => true,
            'file_manager' => true,
            'file_remove' => true,
            'file_tree' => true,
            'file_update' => true,
            'file_upload' => true,
            'file_view' => true,
            'flush_sessions' => true,
            'frames' => true,
            'help' => true,
            'home' => true,
            'import_static' => true,
            'languages' => true,
            'lexicons' => true,
            'list' => true,
            'load' => true,
            'logout' => true,
            'logs' => true,
            'menus' => true,
            'menu_reports' => true,
            'menu_security' => true,
            'menu_site' => true,
            'menu_support' => true,
            'menu_system' => true,
            'menu_tools' => true,
            'menu_user' => true,
            'messages' => true,
            'namespaces' => true,
            'new_category' => true,
            'new_chunk' => true,
            'new_context' => true,
            'new_document' => true,
            'new_document_in_root' => true,
            'new_plugin' => true,
            'new_propertyset' => true,
            'new_role' => true,
            'new_snippet' => true,
            'new_static_resource' => true,
            'new_symlink' => true,
            'new_template' => true,
            'new_tv' => true,
            'new_user' => true,
            'new_weblink' => true,
            'packages' => true,
            'policy_delete' => true,
            'policy_edit' => true,
            'policy_new' => true,
            'policy_save' => true,
            'policy_template_delete' => true,
            'policy_template_edit' => true,
            'policy_template_new' => true,
            'policy_template_save' => true,
            'policy_template_view' => true,
            'policy_view' => true,
            'property_sets' => true,
            'providers' => true,
            'publish_document' => true,
            'purge_deleted' => true,
            'remove' => true,
            'remove_locks' => true,
            'resource_duplicate' => true,
            'resourcegroup_delete' => true,
            'resourcegroup_edit' => true,
            'resourcegroup_new' => true,
            'resourcegroup_resource_edit' => true,
            'resourcegroup_resource_list' => true,
            'resourcegroup_save' => true,
            'resourcegroup_view' => true,
            'resource_quick_create' => true,
            'resource_quick_update' => true,
            'resource_tree' => true,
            'save' => true,
            'save_category' => true,
            'save_chunk' => true,
            'save_context' => true,
            'save_document' => true,
            'save_plugin' => true,
            'save_propertyset' => true,
            'save_role' => true,
            'save_snippet' => true,
            'save_template' => true,
            'save_tv' => true,
            'save_user' => true,
            'search' => true,
            'settings' => true,
            'sources' => true,
            'source_delete' => true,
            'source_edit' => true,
            'source_save' => true,
            'source_view' => true,
            'steal_locks' => true,
            'tree_show_element_ids' => true,
            'tree_show_resource_ids' => true,
            'undelete_document' => true,
            'unlock_element_properties' => true,
            'unpublish_document' => true,
            'usergroup_delete' => true,
            'usergroup_edit' => true,
            'usergroup_new' => true,
            'usergroup_save' => true,
            'usergroup_user_edit' => true,
            'usergroup_user_list' => true,
            'usergroup_view' => true,
            'view' => true,
            'view_category' => true,
            'view_chunk' => true,
            'view_context' => true,
            'view_document' => true,
            'view_element' => true,
            'view_eventlog' => true,
            'view_offline' => true,
            'view_plugin' => true,
            'view_propertyset' => true,
            'view_role' => true,
            'view_snippet' => true,
            'view_sysinfo' => true,
            'view_template' => true,
            'view_tv' => true,
            'view_unpublished' => true,
            'view_user' => true,
            'workspaces' => true,
          ),
        ),
        1 => 
        array (
          'principal' => 1,
          'authority' => 9999,
          'policy' => 
          array (
            'quip.comment_approve' => true,
            'quip.comment_list' => true,
            'quip.comment_list_unapproved' => true,
            'quip.comment_remove' => true,
            'quip.comment_update' => true,
            'quip.thread_list' => true,
            'quip.thread_manage' => true,
            'quip.thread_remove' => true,
            'quip.thread_truncate' => true,
            'quip.thread_view' => true,
            'quip.thread_update' => true,
          ),
        ),
      ),
    ),
  ),
);