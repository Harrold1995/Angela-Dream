<?php
include_once(get_template_directory() . '/anps-framework/classes/Dummy.php');

if (isset($_GET['save_dummy'])) {
        $anps_dummy->save();
}
?>
<script type="text/javascript">
    function anps_dummy() {
        var reply = confirm("WARNING: You have already insert dummy content and by inserting it again, you will have duplicate content.\r\n\We recommend doing this ONLY if something went wrong the first time and you have already cleared the content.");
        return reply;
    }
</script>
<form action="themes.php?page=theme_options&sub_page=dummy_content&save_dummy" method="post">
    <div class="content-inner envoo-dummy">
        <h3><?php esc_html_e("Insert dummy content: posts, pages, categories", "hairdresser"); ?></h3>
        <p><?php _e("Importing demo content is the fastest way to get you started. <br/> Please <strong>install all plugins required by the theme</strong> before importing content. If you already have some content on your site, make a backup just in case.", "hairdresser"); ?></p>

        <div class="clear"></div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demoimport_screen1.jpg" />
                <div class="demotitle"><h4>Classic demo</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy1" class="dummy" <?php if ($anps_dummy->select()) : ?> onclick = "return anps_dummy(); " id="dummy"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "hairdresser"); ?>" />
                    <a class="launch" href="http://anpsthemes.com/hairdresser/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demoimport_screen2.jpg" />
                <div class="demotitle"><h4>Fullscreen demo</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy2" class="dummy" <?php if ($anps_dummy->select()) : ?> onclick = "return anps_dummy(); " id="dummy2"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "hairdresser"); ?>" />
                    <a class="launch" href="http://anpsthemes.com/hairdresser-demo2/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demoimport_screen3.jpg" />
                <div class="demotitle"><h4>Alternative demo</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy3" class="dummy" <?php if ($anps_dummy->select()) : ?> onclick = "return anps_dummy(); " id="dummy3"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "hairdresser"); ?>" />
                    <a class="launch" href="http://anpsthemes.com/hairdresser-demo3/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demoimport_screen4.jpg" />
                <div class="demotitle"><h4><?php esc_html_e('White demo', 'hairdresser'); ?></h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy4" class="dummy" <?php if ($anps_dummy->select()) : ?> onclick = "return anps_dummy(); " id="dummy4"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "hairdresser"); ?>" />
                    <a class="launch" href="http://anpsthemes.com/hairdresser-demo4/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demoimport_screen5.jpg" />
                <div class="demotitle"><h4><?php esc_html_e('White demo', 'hairdresser'); ?></h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy5" class="dummy" <?php if ($anps_dummy->select()) : ?> onclick = "return anps_dummy(); " id="dummy5"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "hairdresser"); ?>" />
                    <a class="launch" href="http://anpsthemes.com/hairdresser-demo5/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demoimport_screen6.jpg" />
                <div class="demotitle"><h4><?php esc_html_e('Fancy demo', 'hairdresser'); ?></h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy6" class="dummy" <?php if ($anps_dummy->select()) : ?> onclick = "return anps_dummy(); " id="dummy6"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "hairdresser"); ?>" />
                    <a class="launch" href="http://anpsthemes.com/hairdresser-demo6/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="absolute fullscreen importspin">
            <div class="table">
                <div class="table-cell center">
                    <div class="messagebox">
                    <i class="fa fa-cog fa-spin" style="font-size:30px;"></i>
                        <h2><strong>Import might take some time, please be patient</strong></h2>

                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
