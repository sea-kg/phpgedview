{strip}
{if $packageMenuTitle}<a class="dropdown-toggle" data-toggle="dropdown" href="#"> {tr}{$packageMenuTitle}{/tr} <b class="caret"></b></a>{/if}
<ul class="{$packageMenuClass}">
	<li><a class="item" href="{$smarty.const.PHPGEDVIEW_PKG_URL}index.php">{tr}List GEDCOM's{/tr}</a></li>
	<li><a class="item" href="{$smarty.const.PHPGEDVIEW_PKG_URL}reportengine.php">{tr}List GEDCOM Reports{/tr}</a></li>
	{if $gBitUser->hasPermission( 'tiki_p_admin_phpgedview' )}
		<li><a class="item" href="{$smarty.const.PHPGEDVIEW_PKG_URL}admin/admin_gedcoms.php">{tr}Load GEDCOM{/tr}</a></li>
		<li><a class="item" href="{$smarty.const.KERNEL_PKG_URL}admin/index.php?page=phpgedview">{tr}Admin Genealogy{/tr}</a></li>
	{/if}
</ul>
{/strip}
