<?php
	$profile_data = $db();
	// debug($profile_data);
	$info = $profile_data['profile']['user'];
?>
<h1>User Info</h1>
<form class="form-validate" action="dashboard/profile/<?php echo $info['id'];?>" method="post">
	<label>
		First Name
		<input type="text" name="user[first_name]" value="<?php echo $info['first_name'];?>">
	</label>
	<label>
		Last Name
		<input type="text" name="user[last_name]" value="<?php echo $info['last_name'];?>">
	</label>
	<label>
		Email
		<input type="email" name="user[email_address]" value="<?php echo $info['email_address'];?>">
	</label>
	<label>
		Farm name
		<input type="text" name="user[farm_name]" value="<?php echo $info['farm_name'];?>">
	</label>
	<label>
		Actvity
		<select name="user[activity_id]">
			<?php 
			$selected = $profile_data['profile_dropdown']['selected'];
			$select = $profile_data['profile_dropdown']['select'];
			foreach ($select as $id => $value): ?>
				<option<?php echo $selected == $id ? ' selected="selected"' : '';?> value="<?php echo $id;?>"><?php echo $value;?></option>
			<?php endforeach ?>
		</select>
	</label>
	<button>Save</button>
</form>
<?php
	$settings = $profile_data['app_settings'];
	// debug($settings);
?>
<h1>User App Settings</h1>
<form class="form-validate" action="dashboard/profile/<?php echo $info['id'];?>" method="post">
	<?php foreach ($settings as $id => $row): ?>
		<label>
			<?php echo $row['label'];?>
			<?php if ($row['checkbox']): ?>
				<?php if ($row['value'] == 'checked'): ?>
					<input type="checkbox" name="user_app_settings[<?php echo $id;?>][value]" checked="checked" value="1" />
				<?php else: ?>
					<input type="checkbox" name="user_app_settings[<?php echo $id;?>][value]" value="1" />
				<?php endif ?>
			<?php else: ?>
				<?php echo $row['label'];?>
				<input type="text" name="user_app_settings[<?php echo $id;?>][value]" value="<?php echo $row['value'];?>" />
			<?php endif ?>
			<input type="hidden" name="user_app_settings[<?php echo $id;?>][checkbox]" value="<?php echo $row['checkbox'];?>" />
		</label>
	<?php endforeach ?>
	<button>Save</button>
</form>
<?php
	$locations = $profile_data['profile']['user_location'];
	// debug($locations);
?>
<!-- MULTIPLE TO KAYA DAPAT MATRON UI NG ADD ANOTHER -->
<h1>User Locations</h1>
<form class="form-validate" action="dashboard/profile/<?php echo $info['id'];?>" method="post">
	<?php foreach ($locations as $key => $row): ?>
		<?php
			$latlng = '';
			if ($row['lat'] != '' AND $row['lng'] != '') {
				$latlng = json_encode(['lat'=>$row['lat'], 'lng'=>$row['lng']]);
			}
		?>
		<div class="location-panel">
			<div class="map-box" style="width: 100%; height: 200pt;"></div>
			<input type="hidden" class="id" name="user_location[<?php echo $key;?>][id]" value="<?php echo $row['id'];?>" />
			<label>
				Address
				<input type="text" class="address" name="user_location[<?php echo $key;?>][address]" required="required" value="<?php echo $row['address'];?>" />
			</label>
			<input type="hidden" class="latlng" name="user_location[<?php echo $key;?>][latlng]" value='<?php echo $latlng;?>' />
		</div>
	<?php endforeach ?>
	<button>Save</button>
</form>
<button>Add Location</button>