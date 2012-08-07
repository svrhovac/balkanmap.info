<div id="ga-panel-home-div">
	<h2>Google Analytics {$_langs.settings}</h2>
	<form name="form" id="form" method="post" action="{$managerUrl}">
		<p>
			<label for='tableId'>{$_langs.site_select}</label>
			<select name="siteSelect" id="siteSelect">
			{foreach $profiles as $profile}
				<option value="{$profile.title}|{$profile.accountId}|{$profile.tableId}|{$profile.webPropertyId}">{$profile.title}</option>
			{/foreach}
			</select>
		</p>
		<p>
			<input type="submit" value="Submit"/>
		</p>
	</form>
</div>