<div class="wrap">
	
	<div id="icon-options-general" class="icon32"></div>
	<h2>UntraceMe dereferer service</h2>
	
	<div id="poststuff">
	
		<div id="post-body" class="metabox-holder columns-2">
		
			<!-- main content -->
			<div id="post-body-content">
				
				<div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					
						<h3><span>Plugin settings</span></h3>
						<div class="inside">
                        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="untrace_settings" style="margin-top:2em;margin-left:1em;">
                        
                            <?php echo __('<h4>Do you want this plugin to add the links on the bottom of your page or post?</h4>') ?>
                            

                            <input type="radio" name="Display" value="Y" <?php echo $opt['Display'] == 'Y' ? 'checked="checked"' : '' ?> /> <?php echo __('Yes') ?>
                            <input type="radio" name="Display" value="N" <?php echo $opt['Display'] == 'N' ? 'checked="checked"' : '' ?> /> <?php echo __('No') ?>
                            <br /><br />
                            
                            <?php echo __('<h4>Wich links do you want to show the public?</h4>') ?>
                            <select name="showLinks" size="1" onchange="this.form.showLinks.value = this.form.showLinks.value;" class="regular-text">
                            
                            <?php foreach ($showLinks as $item): ?>
                            
                            <option <?php echo $item['value'] == $opt['showLinks'] ? 'selected' : '' ?> value="<?php echo $item['value'] ?>"><?php echo $item['name'] ?></option>
                            
                            <?php endforeach ?>
                            </select>
                            
                            <br /><br />
                            <?php echo __('<h4>How do you want the links to be showed?</h4>') ?>
                            <select name="showTypes" size="1" onchange="this.form.showTypes.value = this.form.showTypes.value;" class="regular-text">
                            
                            <?php foreach ($showTypes as $item): ?>
                            
                            <option <?php echo $item['value'] == $opt['showTypes'] ? 'selected' : '' ?> value="<?php echo $item['value'] ?>"><?php echo $item['name'] ?></option>
                            
                            <?php endforeach ?>
                            </select>
                            
                            <br /><br />
                            <?php echo __('<h4>Want to hide all external links with UntraceMe?</h4>') ?>
                            

                            <input type="radio" name="hideRef" value="Y" <?php echo $opt['hideRef'] == 'Y' ? 'checked="checked"' : '' ?> /> <?php echo __('Yes') ?>
                            <input type="radio" name="hideRef" value="N" <?php echo $opt['hideRef'] == 'N' ? 'checked="checked"' : '' ?> /> <?php echo __('No') ?>
                            
                             &nbsp;&nbsp; => &nbsp;&nbsp; <strong>IMPORTANT:</strong> If hide referers is activated you must add <strong>untrace.me</strong> to the <strong>UntraceMe Referers</strong> settings. If you do not do this your visitors will be redirected twice.
                            
                            <br /><br />
                            <input type="submit" name="save" class="button-primary" value="<?php echo __('Save my Untrace settings') ?>" />
                        
                        </form>
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
                    
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
				
			</div> <!-- post-body-content -->
			
			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">
				
                <div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					
						<h3><span>Plugin Support</span></h3>
						<div class="inside">
							If you need any support for this plugin, then please do not hesitate and contact us via the button below.<br /><br />
                            
                            <!--Place this code where you want VIP widget to be rendered -->
                            <div class="casengo-vipbtn"><!-- subdomain="phpapps" group="8472" position="inline" label="Plugin Support" theme="blue"   --></div>
                            
                            <!--Place this code after the last Casengo VIP widget -->
                            <script type="text/javascript">
                            	(function() {
                            		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                            		po.src = '//phpapps.casengo.com/apis/vip-widget.js?r=5f04ec30e60fb14a1235fc2c2a2c1867e1e723ff';
                            		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                            	})();
                            </script>
                            
                            <br />
                            <em>Support is provided by PHPApps</em>
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
                
                <div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					
						<h3><span>About this plugin</span></h3>
						<div class="inside">
                            Webmasters can use this tool to prevent their site from appearing in the backlink statistics of another webpage and server logs of referred pages as referrer. The operators of the referred pages cannot see where their visitors come from any more. Untrace.me provides a slick, quality derefering service for free. No ads, interstitials or popups. We promise.
                            
                            <br /><br />
							More info about this plugin can be found at our website, <a href="http://www.untrace.me" target="_blank">www.untrace.me</a>.
                            <br /><br />
                            &copy; Copyright 2012 - <? echo date("Y");?> Untrace.me
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
                
                
			
			     <div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					
						<h3><span>How does Untrace.me works?</span></h3>
						<div class="inside">
							When using Untrace.me you don't link directly to the external target web page but to Untrace.me which redirects your users to the desired page then. So the target page doesn't get to know that the user actually came from your site.
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
				
			</div> <!-- #postbox-container-1 .postbox-container -->
			
		</div> <!-- #post-body .metabox-holder .columns-2 -->
		
		<br class="clear">
	</div> <!-- #poststuff -->
	
</div>