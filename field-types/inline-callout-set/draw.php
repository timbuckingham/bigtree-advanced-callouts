<?php
	/**
	 * @global BigTreeAdmin $admin
	 * @global array $bigtree
	 * @global array $field
	 */
	
	// Pretend to be vanilla callouts for layout purposes
	$field["type"] = "callouts";
	
	$callout_number = 0;
	
	foreach ($field["settings"]["prefilled"] as $entry) {
		$callout = $admin->getCallout($entry["type"]);
		
		if (!empty($callout["resources"]) && is_array($callout["resources"])) {
?>
<fieldset
	class="callouts<?php if (!empty($bigtree["last_resource_type"]) && $bigtree["last_resource_type"] == "callouts") { ?> callouts_no_margin<?php } ?>">
	<input type="hidden" name="<?=$field["key"]?>[<?=$callout_number?>][type]" value="<?=$callout["id"]?>"/>
	<?php
		if ($entry["title"]) {
	?>
	<h3><?=BigTree::safeEncode($entry["title"])?></h3>
	<br/>
	<?php
		}
		
		foreach ($callout["resources"] as $resource) {
			$settings = [];
			
			if (!empty($resource["settings"])) {
				$settings = $resource["settings"];
			} else if (!empty($resource["options"])) {
				$settings = $resource["options"];
			}
			
			$callout_field = [
				"type" => $resource["type"],
				"title" => $resource["title"],
				"subtitle" => $resource["subtitle"],
				"key" => $field["key"]."[$callout_number][".$resource["id"]."]",
				"has_value" => isset($field["value"][$callout_number][$resource["id"]]),
				"value" => $field["value"][$callout_number][$resource["id"]] ?? "",
				"tabindex" => $bigtree["tabindex"]++,
				"settings" => $settings,
			];
			
			if (empty($callout_field["settings"]["directory"])) {
				$callout_field["settings"]["directory"] = "files/callouts/";
			}
			
			BigTreeAdmin::drawField($callout_field);
		}
		
		$bigtree["last_resource_type"] = "callouts";
	?>
</fieldset>
<?php
		} else {
?>
<input type="hidden" name="<?=$field["key"]?>[<?=$callout_number?>][type]" value="<?=$callout["id"]?>"/>
<?php
		}
		
		$callout_number++;
	}
?>