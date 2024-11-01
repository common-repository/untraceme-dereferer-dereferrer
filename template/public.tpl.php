<div style="margin-top:2em;">
    <?php if ($opt['Display'] == 'Y'): ?>
    
        <!-- Show all -->
        <?php if ($opt['showLinks'] == 'all'): ?>
        
            <?php if ($opt['showTypes'] == 'link'): ?>
                
                <?php echo __('Short Url:') ?><br />
                <a href="<?php echo get_post_meta($post->ID, 'UntraceUrl', true); ?>"><?php echo get_post_meta($post->ID, 'UntraceUrl', true); ?></a><br /><br />
                
                <?php echo __('Encoded Url:') ?><br />
                <a href="<?php echo get_post_meta($post->ID, 'UntraceUrlEncode', true); ?>"><?php echo get_post_meta($post->ID, 'UntraceUrlEncode', true); ?></a>
            
            <?php endif ?>
            
            <?php if ($opt['showTypes'] == 'input'): ?>
                
                <?php echo __('Short Url:') ?><br />
                <input style='width:98%;' onClick='this.select();' value='<?php echo get_post_meta($post->ID, 'UntraceUrl', true); ?>'><br /><br />
                
                <?php echo __('Encoded Url:') ?><br />
                <input style='width:98%;' onClick='this.select();' value='<?php echo get_post_meta($post->ID, 'UntraceUrlEncode', true); ?>'>
            
            <?php endif ?>
        
        <?php endif ?>
        <!-- End Show all -->
        
        <!-- Show Short only -->
        <?php if ($opt['showLinks'] == 'short'): ?>
        
            <?php if ($opt['showTypes'] == 'link'): ?>
                
                <?php echo __('Short Url:') ?><br />
                <a href="<?php echo get_post_meta($post->ID, 'UntraceUrl', true); ?>"><?php echo get_post_meta($post->ID, 'UntraceUrl', true); ?></a><br /><br />
                
            <?php endif ?>
            
            <?php if ($opt['showTypes'] == 'input'): ?>
                
                <?php echo __('Short Url:') ?><br />
                <input style='width:98%;' onClick='this.select();' value='<?php echo get_post_meta($post->ID, 'UntraceUrl', true); ?>'><br /><br />
   
            <?php endif ?>
        
        <?php endif ?>
        <!-- End Show Short only -->
        
        <!-- Show Encoded only -->
        <?php if ($opt['showLinks'] == 'encode'): ?>
        
            <?php if ($opt['showTypes'] == 'link'): ?>
                
                <?php echo __('Encoded Url:') ?><br />
                <a href="<?php echo get_post_meta($post->ID, 'UntraceUrl', true); ?>"><?php echo get_post_meta($post->ID, 'UntraceUrlEncode', true); ?></a><br /><br />
                
            <?php endif ?>
            
            <?php if ($opt['showTypes'] == 'input'): ?>
                
                <?php echo __('Encoded Url:') ?><br />
                <input style='width:98%;' onClick='this.select();' value='<?php echo get_post_meta($post->ID, 'UntraceUrlEncode', true); ?>'><br /><br />
   
            <?php endif ?>
        
        <?php endif ?>
        <!-- End Show Encoded only -->
        
        
        <!-- Show Raw only -->
        <?php if ($opt['showLinks'] == 'raw'): ?>
        
            <?php if ($opt['showTypes'] == 'link'): ?>
                
                <?php echo __('Untrace Url:') ?><br />
                <a href="<?php echo get_post_meta($post->ID, 'UntraceUrl', true); ?>"><?php echo get_post_meta($post->ID, 'UntraceUrlUntrace', true); ?></a><br /><br />
                
            <?php endif ?>
            
            <?php if ($opt['showTypes'] == 'input'): ?>
                
                <?php echo __('Untrace Url:') ?><br />
                <input style='width:98%;' onClick='this.select();' value='<?php echo get_post_meta($post->ID, 'UntraceUrlUntrace', true); ?>'><br /><br />
   
            <?php endif ?>
        
        <?php endif ?>
        <!-- End Show Raw only -->
        
        
    <?php endif ?>
</div>