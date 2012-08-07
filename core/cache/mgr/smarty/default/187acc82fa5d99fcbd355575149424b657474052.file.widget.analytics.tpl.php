<?php /* Smarty version Smarty-3.0.4, created on 2012-07-02 13:45:49
         compiled from "/home/content/40/8758040/html/sites/balkanmap.info/core/components/analytics/elements/tpl/widget.analytics.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12070378044ff2087d633b75-92819824%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '187acc82fa5d99fcbd355575149424b657474052' => 
    array (
      0 => '/home/content/40/8758040/html/sites/balkanmap.info/core/components/analytics/elements/tpl/widget.analytics.tpl',
      1 => 1341020195,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12070378044ff2087d633b75-92819824',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/home/content/40/8758040/html/sites/balkanmap.info/core/model/smarty/plugins/function.cycle.php';
?><div id="analytics-panel-widget">
    <div id="tab1" class="x-hide-display">
        <div id="tab1-holder">
        <table class="classy" style="width:100%">
        
        <thead>
        <tr>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['date']) ? $_smarty_tpl->getVariable('_langs')->value['date'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['visits']) ? $_smarty_tpl->getVariable('_langs')->value['visits'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['unique_visitors']) ? $_smarty_tpl->getVariable('_langs')->value['unique_visitors'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['pageviews_visits']) ? $_smarty_tpl->getVariable('_langs')->value['pageviews_visits'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['pageviews']) ? $_smarty_tpl->getVariable('_langs')->value['pageviews'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['site_time']) ? $_smarty_tpl->getVariable('_langs')->value['site_time'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['new_visits']) ? $_smarty_tpl->getVariable('_langs')->value['new_visits'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['bounce_rate']) ? $_smarty_tpl->getVariable('_langs')->value['bounce_rate'] : null);?>
</th>
        </tr>
        </thead>
        <tbody>
        <?php  $_smarty_tpl->tpl_vars['visits'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('visitsarr')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['visits']->key => $_smarty_tpl->tpl_vars['visits']->value){
?>
        <tr class="<?php echo smarty_function_cycle(array('values'=>',odd'),$_smarty_tpl);?>
">
                <td><?php echo (isset($_smarty_tpl->tpl_vars['visits']->value['date']) ? $_smarty_tpl->tpl_vars['visits']->value['date'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['visits']->value['visits']) ? $_smarty_tpl->tpl_vars['visits']->value['visits'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['visits']->value['visitors']) ? $_smarty_tpl->tpl_vars['visits']->value['visitors'] : null);?>
</td>
                <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['visits']->value['pageviewsPerVisit']) ? $_smarty_tpl->tpl_vars['visits']->value['pageviewsPerVisit'] : null),2,",",".");?>
  %</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['visits']->value['pageviews']) ? $_smarty_tpl->tpl_vars['visits']->value['pageviews'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['visits']->value['vgTimeOnSite']) ? $_smarty_tpl->tpl_vars['visits']->value['vgTimeOnSite'] : null);?>
</td>
                <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['visits']->value['percentNewVisits']) ? $_smarty_tpl->tpl_vars['visits']->value['percentNewVisits'] : null),2,",",".");?>
 %</td>
                <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['visits']->value['visitBounceRate']) ? $_smarty_tpl->tpl_vars['visits']->value['visitBounceRate'] : null),2,",",".");?>
 %</td>
        </tr>
        <?php }} else { ?>
        <tr>
            <th colspan="5"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['connection_error']) ? $_smarty_tpl->getVariable('_langs')->value['connection_error'] : null);?>
</th>
        </tr>
        <?php } ?>
        <tr>
                <td><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['total']) ? $_smarty_tpl->getVariable('_langs')->value['total'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->getVariable('general')->value['visits']) ? $_smarty_tpl->getVariable('general')->value['visits'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->getVariable('general')->value['visitors']) ? $_smarty_tpl->getVariable('general')->value['visitors'] : null);?>
</td>
                <td><?php echo number_format((isset($_smarty_tpl->getVariable('general')->value['pageviewsPerVisit']) ? $_smarty_tpl->getVariable('general')->value['pageviewsPerVisit'] : null),2,",",".");?>
 %</td>
                <td><?php echo (isset($_smarty_tpl->getVariable('general')->value['pageviews']) ? $_smarty_tpl->getVariable('general')->value['pageviews'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->getVariable('general')->value['vgTimeOnSite']) ? $_smarty_tpl->getVariable('general')->value['vgTimeOnSite'] : null);?>
</td>
                <td><?php echo number_format((isset($_smarty_tpl->getVariable('general')->value['percentNewVisits']) ? $_smarty_tpl->getVariable('general')->value['percentNewVisits'] : null),2,",",".");?>
 %</td>
                <td><?php echo number_format((isset($_smarty_tpl->getVariable('general')->value['visitBounceRate']) ? $_smarty_tpl->getVariable('general')->value['visitBounceRate'] : null),2,",",".");?>
 %</td>
        </tr>
        </tbody>
        </table>
        </div>
    </div>
    <div id="tab2" class="x-hide-display">
				
        <div id="tab2-holder">
            <h2><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['top_sources']) ? $_smarty_tpl->getVariable('_langs')->value['top_sources'] : null);?>
</h2>
            <table class="classy" style="width: 48%; float:left; margin-right:2%;">
            
	            <thead>
	            <tr>
	                <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['sources']) ? $_smarty_tpl->getVariable('_langs')->value['sources'] : null);?>
</th>
	                <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['visits']) ? $_smarty_tpl->getVariable('_langs')->value['visits'] : null);?>
</th>
	                <th>% <?php echo (isset($_smarty_tpl->getVariable('_langs')->value['new_visits']) ? $_smarty_tpl->getVariable('_langs')->value['new_visits'] : null);?>
</th>
	            </tr>
	            </thead>
	            <tbody>
	            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, null);?>
	            <?php  $_smarty_tpl->tpl_vars['toptraffic'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('toptrafficsource')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['toptraffic']->key => $_smarty_tpl->tpl_vars['toptraffic']->value){
?>
		            <?php if ($_smarty_tpl->getVariable('i')->value==5){?><?php break 1?><?php }?>
			            <tr class="<?php echo smarty_function_cycle(array('values'=>',odd'),$_smarty_tpl);?>
">
			                    <td><?php echo (isset($_smarty_tpl->tpl_vars['toptraffic']->value['source']) ? $_smarty_tpl->tpl_vars['toptraffic']->value['source'] : null);?>
</td>
			                    <td><?php echo (isset($_smarty_tpl->tpl_vars['toptraffic']->value['visits']) ? $_smarty_tpl->tpl_vars['toptraffic']->value['visits'] : null);?>
</td>
			                    <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['toptraffic']->value['percentNewVisits']) ? $_smarty_tpl->tpl_vars['toptraffic']->value['percentNewVisits'] : null),2,",",".");?>
 %</td>
			            </tr>
		            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('i')->value+1, null, null);?>
		            <?php }} else { ?>
		            <tr>
		                <th colspan="5"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['connection_error']) ? $_smarty_tpl->getVariable('_langs')->value['connection_error'] : null);?>
</th>
		            </tr>
	            <?php } ?>
            </tbody>
            </table>
            <table class="classy" style="width: 48%; float:left; margin-right:2%;">
	            <thead>
	            <tr>
	                <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['keywords']) ? $_smarty_tpl->getVariable('_langs')->value['keywords'] : null);?>
</th>
	                <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['visits']) ? $_smarty_tpl->getVariable('_langs')->value['visits'] : null);?>
</th>
	                <th>% <?php echo (isset($_smarty_tpl->getVariable('_langs')->value['new_visits']) ? $_smarty_tpl->getVariable('_langs')->value['new_visits'] : null);?>
</th>
	            </tr>
	            </thead>
	            <tbody>

	            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, null);?>
	            <?php  $_smarty_tpl->tpl_vars['keyword'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('keywords')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['keyword']->key => $_smarty_tpl->tpl_vars['keyword']->value){
?>
		            <?php if ((isset($_smarty_tpl->tpl_vars['keyword']->value['keyword']) ? $_smarty_tpl->tpl_vars['keyword']->value['keyword'] : null)!='(not set)'){?>
			            <?php if ($_smarty_tpl->getVariable('i')->value==5){?><?php break 1?><?php }?>
			            <tr class="<?php echo smarty_function_cycle(array('values'=>',odd'),$_smarty_tpl);?>
">
				                    <td><?php echo (isset($_smarty_tpl->tpl_vars['keyword']->value['keyword']) ? $_smarty_tpl->tpl_vars['keyword']->value['keyword'] : null);?>
</td>
				                    <td><?php echo (isset($_smarty_tpl->tpl_vars['keyword']->value['visits']) ? $_smarty_tpl->tpl_vars['keyword']->value['visits'] : null);?>
</td>
				                    <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['keyword']->value['percentNewVisits']) ? $_smarty_tpl->tpl_vars['keyword']->value['percentNewVisits'] : null),2,",",".");?>
 %</td>
				            </tr>
			            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('i')->value+1, null, null);?>
		            <?php }?>
	            <?php }} else { ?>
	            <tr>
	                <th colspan="5"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['connection_error']) ? $_smarty_tpl->getVariable('_langs')->value['connection_error'] : null);?>
</th>
	            </tr>
	            <?php } ?>
            </tbody>
            </table>
            <p style="clear:both;"></p>
            <h2><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['referring_sites']) ? $_smarty_tpl->getVariable('_langs')->value['referring_sites'] : null);?>
</h2>
            <table class="classy" style="width: 100%;">
            
            <thead>
            <tr>
                <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['sources']) ? $_smarty_tpl->getVariable('_langs')->value['sources'] : null);?>
</th>
                <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['visits']) ? $_smarty_tpl->getVariable('_langs')->value['visits'] : null);?>
</th>
                <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['pages_visits']) ? $_smarty_tpl->getVariable('_langs')->value['pages_visits'] : null);?>
</th>
                <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['average_site_time']) ? $_smarty_tpl->getVariable('_langs')->value['average_site_time'] : null);?>
</th>
                <th>% <?php echo (isset($_smarty_tpl->getVariable('_langs')->value['new_visits']) ? $_smarty_tpl->getVariable('_langs')->value['new_visits'] : null);?>
</th>
                <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['bounce_rate']) ? $_smarty_tpl->getVariable('_langs')->value['bounce_rate'] : null);?>
</th>
            </tr>
            </thead>
            <tbody>
            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, null);?>
            <?php  $_smarty_tpl->tpl_vars['trafficreffered'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('toptrafficsource')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['trafficreffered']->key => $_smarty_tpl->tpl_vars['trafficreffered']->value){
?>
                 <?php if ((isset($_smarty_tpl->tpl_vars['trafficreffered']->value['source']) ? $_smarty_tpl->tpl_vars['trafficreffered']->value['source'] : null)!='google'&&(isset($_smarty_tpl->tpl_vars['trafficreffered']->value['source']) ? $_smarty_tpl->tpl_vars['trafficreffered']->value['source'] : null)!='(direct)'&&(isset($_smarty_tpl->tpl_vars['trafficreffered']->value['source']) ? $_smarty_tpl->tpl_vars['trafficreffered']->value['source'] : null)!='localhost'&&(isset($_smarty_tpl->tpl_vars['trafficreffered']->value['source']) ? $_smarty_tpl->tpl_vars['trafficreffered']->value['source'] : null)!='bing'&&(isset($_smarty_tpl->tpl_vars['trafficreffered']->value['source']) ? $_smarty_tpl->tpl_vars['trafficreffered']->value['source'] : null)!='google.nl'){?>
                 <?php if ($_smarty_tpl->getVariable('i')->value==10){?><?php break 1?><?php }?>

            <tr class="<?php echo smarty_function_cycle(array('values'=>',odd'),$_smarty_tpl);?>
">
                    <td><?php echo (isset($_smarty_tpl->tpl_vars['trafficreffered']->value['source']) ? $_smarty_tpl->tpl_vars['trafficreffered']->value['source'] : null);?>
</td>
                    <td><?php echo (isset($_smarty_tpl->tpl_vars['trafficreffered']->value['visits']) ? $_smarty_tpl->tpl_vars['trafficreffered']->value['visits'] : null);?>
</td>
                    <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['trafficreffered']->value['pageviewsPerVisit']) ? $_smarty_tpl->tpl_vars['trafficreffered']->value['pageviewsPerVisit'] : null),2,",",".");?>
 %</td>
                    <td><?php echo (isset($_smarty_tpl->tpl_vars['trafficreffered']->value['vgTimeOnSite']) ? $_smarty_tpl->tpl_vars['trafficreffered']->value['vgTimeOnSite'] : null);?>
</td>
                    <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['trafficreffered']->value['percentNewVisits']) ? $_smarty_tpl->tpl_vars['trafficreffered']->value['percentNewVisits'] : null),2,",",".");?>
 %</td>
                    <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['trafficreffered']->value['visitBounceRate']) ? $_smarty_tpl->tpl_vars['trafficreffered']->value['visitBounceRate'] : null),2,",",".");?>
 %</td>
            </tr>
            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('i')->value+1, null, null);?>

            <?php }?>
            <?php }} else { ?>
            <tr>
                <th colspan="5"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['connection_error']) ? $_smarty_tpl->getVariable('_langs')->value['connection_error'] : null);?>
</th>
            </tr>
            <?php } ?>

            </tbody>
            </table>
        </div>
    </div>
    <div id="tab3" class="x-hide-display">
        <h2><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['top_landing_pages']) ? $_smarty_tpl->getVariable('_langs')->value['top_landing_pages'] : null);?>
</h2>
            <table class="classy" style="width: 100%;">
        <thead>
        <tr>
            <th style="width: 40%;"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['page']) ? $_smarty_tpl->getVariable('_langs')->value['page'] : null);?>
</th>
            <th style="width: 20%;"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['entrances']) ? $_smarty_tpl->getVariable('_langs')->value['entrances'] : null);?>
</th>
            <th style="width: 20%;"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['bounces']) ? $_smarty_tpl->getVariable('_langs')->value['bounces'] : null);?>
</th>
            <th style="width: 20%;"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['bounce_rate']) ? $_smarty_tpl->getVariable('_langs')->value['bounce_rate'] : null);?>
</th>
        </tr>
        </thead>
        <tbody>
        <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, null);?>
        <?php  $_smarty_tpl->tpl_vars['toppage'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('toplandingspages')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['toppage']->key => $_smarty_tpl->tpl_vars['toppage']->value){
?>
        <?php if ($_smarty_tpl->getVariable('i')->value==10){?><?php break 1?><?php }?>
        <tr class="<?php echo smarty_function_cycle(array('values'=>',odd'),$_smarty_tpl);?>
">
                <td><?php echo (isset($_smarty_tpl->tpl_vars['toppage']->value['pagePath']) ? $_smarty_tpl->tpl_vars['toppage']->value['pagePath'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['toppage']->value['entrances']) ? $_smarty_tpl->tpl_vars['toppage']->value['entrances'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['toppage']->value['bounces']) ? $_smarty_tpl->tpl_vars['toppage']->value['bounces'] : null);?>
</td>
                <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['toppage']->value['entranceBounceRate']) ? $_smarty_tpl->tpl_vars['toppage']->value['entranceBounceRate'] : null),2,",",".");?>
 %</td>

        </tr>
         <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('i')->value+1, null, null);?>
        <?php }} else { ?>
        <tr>
            <th colspan="5"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['connection_error']) ? $_smarty_tpl->getVariable('_langs')->value['connection_error'] : null);?>
</th>
        </tr>
        <?php } ?>
        </tbody>
        </table>
        <h2><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['top_exit_pages']) ? $_smarty_tpl->getVariable('_langs')->value['top_exit_pages'] : null);?>
</h2>
            <table class="classy" style="width: 100%;">
        <thead>
        <tr>
            <th style="width: 40%;"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['page']) ? $_smarty_tpl->getVariable('_langs')->value['page'] : null);?>
</th>
            <th style="width: 20%;"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['exits']) ? $_smarty_tpl->getVariable('_langs')->value['exits'] : null);?>
</th>
            <th style="width: 20%;"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['pageviews']) ? $_smarty_tpl->getVariable('_langs')->value['pageviews'] : null);?>
</th>
            <th style="width: 20%;">% <?php echo (isset($_smarty_tpl->getVariable('_langs')->value['exit']) ? $_smarty_tpl->getVariable('_langs')->value['exit'] : null);?>
</th>
        </tr>
        </thead>
        <tbody>
        <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, null);?>
         <?php  $_smarty_tpl->tpl_vars['exitpage'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('topexitpages')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['exitpage']->key => $_smarty_tpl->tpl_vars['exitpage']->value){
?>
        <?php if ($_smarty_tpl->getVariable('i')->value==10){?><?php break 1?><?php }?>
        <tr class="<?php echo smarty_function_cycle(array('values'=>',odd'),$_smarty_tpl);?>
">
                <td><?php echo (isset($_smarty_tpl->tpl_vars['exitpage']->value['pagePath']) ? $_smarty_tpl->tpl_vars['exitpage']->value['pagePath'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['exitpage']->value['exits']) ? $_smarty_tpl->tpl_vars['exitpage']->value['exits'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['exitpage']->value['pageviews']) ? $_smarty_tpl->tpl_vars['exitpage']->value['pageviews'] : null);?>
</td>
                <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['exitpage']->value['exitRate']) ? $_smarty_tpl->tpl_vars['exitpage']->value['exitRate'] : null),2,",",".");?>
 %</td>

        </tr>
         <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('i')->value+1, null, null);?>
        <?php }} else { ?>
        <tr>
            <th colspan="5"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['connection_error']) ? $_smarty_tpl->getVariable('_langs')->value['connection_error'] : null);?>
</th>
        </tr>
        <?php } ?>
        </tbody>
        </table>

    </div>
    <div id="tab4" class="x-hide-display">
        <div id="goals-holder">
        <h2><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['goals_part1']) ? $_smarty_tpl->getVariable('_langs')->value['goals_part1'] : null);?>
 <?php echo (isset($_smarty_tpl->getVariable('general')->value['allGoals']) ? $_smarty_tpl->getVariable('general')->value['allGoals'] : null);?>
 <?php echo (isset($_smarty_tpl->getVariable('_langs')->value['goals_part2']) ? $_smarty_tpl->getVariable('_langs')->value['goals_part2'] : null);?>
</h2>
        <table class="classy" style="width: 48%;">
        <thead>
        <tr>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['goals']) ? $_smarty_tpl->getVariable('_langs')->value['goals'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['conversions']) ? $_smarty_tpl->getVariable('_langs')->value['conversions'] : null);?>
</th>
        </tr>
        </thead>
        <tbody>
        <?php  $_smarty_tpl->tpl_vars['goal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('goalstable')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['goal']->key => $_smarty_tpl->tpl_vars['goal']->value){
?>
        <tr class="<?php echo smarty_function_cycle(array('values'=>',odd'),$_smarty_tpl);?>
">
            <td><?php echo (isset($_smarty_tpl->tpl_vars['goal']->value['goalname']) ? $_smarty_tpl->tpl_vars['goal']->value['goalname'] : null);?>
</td>
            <td><?php echo (isset($_smarty_tpl->tpl_vars['goal']->value['completions']) ? $_smarty_tpl->tpl_vars['goal']->value['completions'] : null);?>
</td>
        </tr>
         <?php }} ?>
        </tbody>
        </table>
        </div>

    </div>
    <div id="tab5" class="x-hide-display">
            <table class="classy" style="width: 100%;">
        <thead>
        <tr>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['keywords']) ? $_smarty_tpl->getVariable('_langs')->value['keywords'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['visits']) ? $_smarty_tpl->getVariable('_langs')->value['visits'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['pages_visits']) ? $_smarty_tpl->getVariable('_langs')->value['pages_visits'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['average_site_time']) ? $_smarty_tpl->getVariable('_langs')->value['average_site_time'] : null);?>
</th>
            <th>% <?php echo (isset($_smarty_tpl->getVariable('_langs')->value['new_visits']) ? $_smarty_tpl->getVariable('_langs')->value['new_visits'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['bounce_rate']) ? $_smarty_tpl->getVariable('_langs')->value['bounce_rate'] : null);?>
</th>
        </tr>
        </thead>
        <tbody>
        <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, null);?>
         <?php  $_smarty_tpl->tpl_vars['keyword'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('keywords')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['keyword']->key => $_smarty_tpl->tpl_vars['keyword']->value){
?>
         <?php if ((isset($_smarty_tpl->tpl_vars['keyword']->value['keyword']) ? $_smarty_tpl->tpl_vars['keyword']->value['keyword'] : null)!='(not set)'){?>
         <?php if ($_smarty_tpl->getVariable('i')->value==20){?><?php break 1?><?php }?>
        <tr class="<?php echo smarty_function_cycle(array('values'=>',odd'),$_smarty_tpl);?>
">
                <td><?php echo (isset($_smarty_tpl->tpl_vars['keyword']->value['keyword']) ? $_smarty_tpl->tpl_vars['keyword']->value['keyword'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['keyword']->value['visits']) ? $_smarty_tpl->tpl_vars['keyword']->value['visits'] : null);?>
</td>
                <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['keyword']->value['pageviewsPerVisit']) ? $_smarty_tpl->tpl_vars['keyword']->value['pageviewsPerVisit'] : null),2,",",".");?>
 %</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['keyword']->value['vgTimeOnSite']) ? $_smarty_tpl->tpl_vars['keyword']->value['vgTimeOnSite'] : null);?>
</td>
                <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['keyword']->value['percentNewVisits']) ? $_smarty_tpl->tpl_vars['keyword']->value['percentNewVisits'] : null),2,",",".");?>
 %</td>
                <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['keyword']->value['visitBounceRate']) ? $_smarty_tpl->tpl_vars['keyword']->value['visitBounceRate'] : null),2,",",".");?>
 %</td>
        </tr>
        <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('i')->value+1, null, null);?>
        <?php }?>
        <?php }} else { ?>
        <tr>
            <th colspan="5"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['connection_error']) ? $_smarty_tpl->getVariable('_langs')->value['connection_error'] : null);?>
</th>
        </tr>
        <?php } ?>
        </tbody>
        </table>

    </div>
    <div id="tab6" class="x-hide-display">
            <table class="classy" style="width: 100%;">
        <thead>
        <tr>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['search_keyword']) ? $_smarty_tpl->getVariable('_langs')->value['search_keyword'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['search_uniques']) ? $_smarty_tpl->getVariable('_langs')->value['search_uniques'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['search_result_views']) ? $_smarty_tpl->getVariable('_langs')->value['search_result_views'] : null);?>
</th>
            <th>% <?php echo (isset($_smarty_tpl->getVariable('_langs')->value['search_exits']) ? $_smarty_tpl->getVariable('_langs')->value['search_exits'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['search_duration']) ? $_smarty_tpl->getVariable('_langs')->value['search_duration'] : null);?>
</th>
            <th><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['search_depth']) ? $_smarty_tpl->getVariable('_langs')->value['search_depth'] : null);?>
</th>
        </tr>
        </thead>
        <tbody>
        <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, null);?>
         <?php  $_smarty_tpl->tpl_vars['sitesearch'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sitesearches')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sitesearch']->key => $_smarty_tpl->tpl_vars['sitesearch']->value){
?>
         <?php if ($_smarty_tpl->getVariable('i')->value==20){?><?php break 1?><?php }?>
        <tr class="<?php echo smarty_function_cycle(array('values'=>',odd'),$_smarty_tpl);?>
">
                <td><?php echo (isset($_smarty_tpl->tpl_vars['sitesearch']->value['searchKeyword']) ? $_smarty_tpl->tpl_vars['sitesearch']->value['searchKeyword'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['sitesearch']->value['searchUniques']) ? $_smarty_tpl->tpl_vars['sitesearch']->value['searchUniques'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['sitesearch']->value['searchResultViews']) ? $_smarty_tpl->tpl_vars['sitesearch']->value['searchResultViews'] : null);?>
</td>
                <td><?php echo number_format((isset($_smarty_tpl->tpl_vars['sitesearch']->value['searchExitRate']) ? $_smarty_tpl->tpl_vars['sitesearch']->value['searchExitRate'] : null),2,",",".");?>
  %</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['sitesearch']->value['searchDuration']) ? $_smarty_tpl->tpl_vars['sitesearch']->value['searchDuration'] : null);?>
</td>
                <td><?php echo (isset($_smarty_tpl->tpl_vars['sitesearch']->value['searchDepth']) ? $_smarty_tpl->tpl_vars['sitesearch']->value['searchDepth'] : null);?>
</td>
        </tr>
        <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('i')->value+1, null, null);?>
        <?php }} else { ?>
        <tr>
            <th colspan="5"><?php echo (isset($_smarty_tpl->getVariable('_langs')->value['no_result']) ? $_smarty_tpl->getVariable('_langs')->value['no_result'] : null);?>
</th>
        </tr>
        <?php } ?>
        </tbody>
        </table>

    </div>
</div>
