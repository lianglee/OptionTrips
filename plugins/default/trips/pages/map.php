<?php ?>
<div id="google-map-trips"><?php echo ossn_print('trips:message:first'); ?></div>

<div id="add-trip">
	<label> <?php echo ossn_print('trips:label:location'); ?></label>
	<input type="text" placeholder="<?php echo ossn_print('enter:location'); ?>" id="my-address">
	<button id="getCords" class="btn-action" onClick="codeAddress();">Guardar</button>
</div>
 	