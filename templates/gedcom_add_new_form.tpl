	print "<tr><td class=\"topbottombar $TEXT_DIRECTION\" colspan=\"2\">";
	print "<a href=\"javascript: ".$pgv_lang["add_new_gedcom"]."\" onclick=\"expand_layer('add_new_gedcom');return false\"><img id=\"add_new_gedcom_img\" src=\"".$PGV_IMAGE_DIR."/";
	if ($startimport != "true") print $PGV_IMAGES["minus"]["other"];
	else print $PGV_IMAGES["plus"]["other"];
	print "\" border=\"0\" width=\"11\" height=\"11\" alt=\"\" /></a>";
	print_help_link("add_gedcom_instructions", "qm","add_new_gedcom");
	print "&nbsp;<a href=\"javascript: ".$pgv_lang["add_new_gedcom"]."\" onclick=\"expand_layer('add_new_gedcom');return false\">".$pgv_lang["add_new_gedcom"]."</a>";
	print "</td></tr>";
	print "<tr><td class=\"optionbox\">";
	print "<div id=\"add-form\" style=\"display: ";
	if ($startimport != "true") print "block ";
	else print "none ";
	print "\">";
		?>
		<input type="hidden" name="action" value="<?php print $action; ?>" />
		<input type="hidden" name="check" value="add_new" />
		<table class="facts_table">
		<?php
		if (!empty($error)) {
				print "<tr><td class=\"optionbox wrap\" colspan=\"2\">";
				print "<span class=\"error\">".$error."</span>\n";
				print "</td></tr>";
		}
		?>
		<tr>
			<td class="descriptionbox width20 wrap">
			<?php print $pgv_lang["gedcom_file"];?>
			</td>
			<td class="optionbox"><input name="GEDFILENAME" type="text" value="<?php if (isset($GEDFILENAME)) print $path.$GEDFILENAME; ?>" size="60" <?php if (isset($GEDFILENAME) && !$no_upload) print "disabled"; ?> /></td>
		</tr>
		</table>
		<?php
	print "</div>";
	print "</td></tr>";
