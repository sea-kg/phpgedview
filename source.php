<?php
/**
 * Displays the details about a source record.  Also shows how many people and families
 * reference this source.
 *
 * phpGedView: Genealogy Viewer
 * Copyright (C) 2002 to 2005 PGV Development Team
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @package PhpGedView
 * @subpackage Charts
 * @version $Id: source.php,v 1.1 2005/12/29 18:25:56 lsces Exp $
 */

require("config.php");
require_once("includes/controllers/source_ctrl.php");

print_header($controller->getPageTitle());
?>
<script language="JavaScript" type="text/javascript">
<!--
	function show_gedcom_record() {
		var recwin = window.open("gedrecord.php?pid=<?php print $controller->sid ?>", "", "top=0,left=0,width=300,height=400,scrollbars=1,scrollable=1,resizable=1");
	}
	function showchanges() {
		window.location = '<?php print $SCRIPT_NAME."?".$QUERY_STRING."&show_changes=yes"; ?>';
	}
//-->
</script>
<table class="list_table">
	<tr>
		<td>
<?php
	if ($controller->accept_success) print "<b>".$pgv_lang["accept_successful"]."</b><br />";
?>
			<span class="name_head"><?php print PrintReady($controller->source->getTitle()); if ($SHOW_ID_NUMBERS) print " &lrm;(".$controller->sid.")&lrm;"; ?></span><br />
		</td>
		<td valign="top">
		<? if (!$controller->isPrintPreview()) {
			 $editmenu = $controller->getEditMenu();
			 $othermenu = $controller->getOtherMenu();
			 if ($editmenu!==false || $othermenu!==false) {
		?>
			<table class="sublinks_table" cellspacing="4" cellpadding="0">
				<tr>
					<td class="list_label <?php print $TEXT_DIRECTION?>" colspan="2"><?php print $pgv_lang['source_menu']?></td>
				</tr>
				<tr>
					<?php if ($editmenu!==false) { ?>
					<td class="sublinks_cell <?php print $TEXT_DIRECTION?>">
					<?php
						$editmenu->printMenu();
					}
					if ($othermenu!==false) {
					?>
					</td>
					<td class="sublinks_cell <?php print $TEXT_DIRECTION?>">
					<?php
					$othermenu->printMenu();
					} // other
					?>
					</td>
				</tr>
			</table>
			<?php }
		} 
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="facts_table">
<?php 
$sourcefacts = $controller->source->getSourceFacts();
foreach($sourcefacts as $indexval => $fact) {
	$factrec = $fact[0];
	$linenum = $fact[1];
	$ft = preg_match("/1\s(_?\w+)\s(.*)/", $factrec, $match);
	if ($ft>0) $fact = $match[1];
	else $fact="";
	$fact = trim($fact);
	if (!empty($fact)) {
		if ($fact=="NOTE") {
			print_main_notes($factrec, 1, $sid, $linenum);
		}
		else {
			print_fact($factrec, $sid, $linenum);
		}
	}
}
// Print media
print_main_media("", "", $sid, "");

//-- new fact link
if ((!$controller->isPrintPreview())&&($controller->userCanEdit())) {
	print_add_new_fact($sid, $sourcefacts, "SOUR");
}
?>
		</table>
		<br /><br />
		<?php print_help_link("sources_listbox_help", "qm","other_records"); ?>
		<span class="label"><?php print $pgv_lang["other_records"]; ?></span>
<?php 
// -- array of names
$myindilist = $controller->source->getSourceIndis();
$myfamlist = $controller->source->getSourceFams();
$ci=count($myindilist);
$cf=count($myfamlist);
if (($ci>0)||($cf>0)) {
	?>
	<table class="list_table">
		<tr>
		<?php if ($ci>0) { ?>
			<td class="list_label">
				<?php print $pgv_lang["individuals"]; ?>
			</td>
		<?php } 
		if ($cf>0) { ?>
			<td class="list_label">
				<?php print $pgv_lang["families"]; ?>
			</td>
		<?php } ?>
		</tr>
		<tr>
			<?php if ($ci>0) { ?>
			<td class="list_value_wrap">
				<ul>
				<?php
				foreach ($myindilist as $key => $value) {
					print_list_person($key, array(check_NN(get_sortable_name($key)), get_gedcom_from_id($value["gedfile"])));
					print "\n";
				}
				if (count($indi_hide)>0) {
					print "<li>".$pgv_lang["hidden"]." (".count($indi_hide).")";
					print_help_link("privacy_error_help", "qm");
					print "</li>";
				}
				?>
				</ul>
			</td>
			<?php }
			if ($cf>0) { ?>
			<td class="list_value_wrap">
				<ul>
				<?php
				foreach ($myfamlist as $key => $value) {
					print_list_family($key, array(get_family_descriptor($key), get_gedcom_from_id($value["gedfile"])));
				}
				if (count($fam_hide)>0) {
					print "<li>".$pgv_lang["hidden"]." (".count($fam_hide).")";
					print_help_link("privacy_error_help", "qm");
					print "</li>";
				}
				?>
				</ul>
			</td>
			<?php } ?>
		</tr>
		<tr>
			<?php if ($ci>0) { ?>
			<td>
				<?php print $pgv_lang["total_indis"]." ".$ci; ?>
				<?php if (count($indi_private)>0) print "&nbsp;(".$pgv_lang["private"]." ".count($indi_private).")"; ?>
				<?php if (count($indi_hide)>0) print "&nbsp;--&nbsp;".$pgv_lang["hidden"]." ".count($indi_hide); ?>
			</td>
			<?php } 
			if ($cf>0) { ?>
			<td>
			<?php print $pgv_lang["total_fams"]." ".$cf; ?>
			<?php if (count($fam_private)>0) print "&nbsp;(".$pgv_lang["private"]." ".count($fam_private).")"; ?>
			<?php if (count($fam_hide)>0) print "&nbsp;--&nbsp;".$pgv_lang["hidden"]." ".count($fam_hide); ?>
			</td>
			<?php } ?>
		</tr>
	</table>
<?php }
else print "&nbsp;&nbsp;&nbsp;<span class=\"warning\"><i>".$pgv_lang["no_results"]."</span>";
?>
	<br />
	<br />
	</td>
</tr>
</table>
<?php print_footer(); ?>